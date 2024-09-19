<template>
  <div class="flex items-center justify-center gap-4">
    <!-- <Button @click="play({ id: 'kick' })" label="Kick">🥁</Button>
    <Button @click="play({ id: 'hihat' })" label="Hi-hat">🎩</Button>
    <Button @click="play({ id: 'snare' })" label="Snare">🍗</Button>
    <Button @click="play({ id: 'cowbell' })" label="Cowbell">🔔</Button> -->

    <!-- black: [700, 1000],
      blue: [2200, 1000],
      brown: [3500, 1000],
      green: [5200, 1000],
      orange: [7100, 1000],
      pink: [8600, 1000],
      purple: [10000, 1000],
      red: [11600, 1000],
      white: [13300, 1000],
      yellow: [14700, 1000], -->
      <input :value="spb" @input="onInput" placeholder="Інтервал в секундах між бісеринами">
      <input 
        :value="round"
        placeholder="Окружність(довжина одного кола)">
      <button @click="tooglePlay" :class="{ play: run }"> 
        <span v-if="!run"> ▶ </span>
        <span v-else > ❚❚ </span> 
      </button>
      <button @click="reset"> 
        <span> ◼ </span>
      </button>
      <v-stage :config="configKonva">
        <v-layer>
          <v-rect
            v-for="item in bitmap"
            :config="getConfig(item)">
          </v-rect>
        </v-layer>
      </v-stage>
      <div 
        v-for="item in groupedItems" 
        :style="{ color: item.color }" 
        :class="{ active : item.isActive }" 
        @click="moveTo(item)" >
        ❤ {{ item.count }}
        <!-- <span v-for="s in item.count">{{ s }}</span> -->
      </div>
  </div>
</template>
<script>
import { onMounted, onUnmounted } from 'vue'
import { useSound } from '@vueuse/sound'
import drumSfx from '../assets/sound/10colors.mp3'
import Button from './Components/Button.vue'

// const useKeyboardBindings = (map) => {
//   const handlePress = (ev) => {
//     const handler = map[ev.key]
//     if (typeof handler === 'function') {
//       handler()
//     }
//   }
  // onMounted(() => {
  //   var c = document.getElementById("c");
  //   var ctx = c.getContext("2d");    
  //   this.vueCanvas = ctx;
  //   console.log(this.vueCanvas);
  //   console.log('_________________________');
  //   // window.addEventListener('keydown', handlePress)
  // })
//   onUnmounted(() => {
//     window.removeEventListener('keydown', handlePress)
//   })
// }
export default {
  data() {
    return {
      rowHeight: 20,
      columnWidth: 25,
      run: true,
      spb: 1,
      round: 16,
      line: [],
      configKonva: {
        width: 500,
        height: 300
      },
      // configCircle: {
      //   x: 100,
      //   y: 100,
      //   radius: 70,
      //   fill: "red",
      //   stroke: "black",
      //   strokeWidth: 4
      // }
    }
  },
  methods: {
    pollData () { // second per BOOSING ^)))))))))
        let frequency = this.spb * 1000
        let isNextActive = false
        let isLast = false
        this.polling = setInterval(() => {
          if (this.run) {
            this.line.forEach((item, index, line) => {
              line.id = index
              if (isNextActive && item.isActive) {
                item.isActive = false
                if (index+1 == line.length) {
                  isLast = true
                } else {
                  line[index+1].isActive = true
                  isNextActive = false
                }
              }
              if (item.isActive) {
                // this.play({id: item.color})
                isNextActive = true
              }
            });
          }
        }, frequency)
    },
    onInput (e) {
      let boosing = e.target.value*1
      if (Number.isInteger(boosing) && boosing > 0) {
        clearInterval(this.polling)
        this.spb = e.target.value
        this.pollData();
      }
    },
    tooglePlay () {
      this.run = !this.run
    },
    reset () {
      clearInterval(this.polling)
      this.line.forEach((el,i,a) => {
        if(!i)
          el.isActive = true
        else
          el.isActive = false
      })
      this.pollData()
    },
    moveTo (item) {
      clearInterval(this.polling)
      this.line.forEach((el,i,a) => {
        if(item.id == el.id)
          el.isActive = true
        else
          el.isActive = false
      })
      this.pollData()
    },
    getConfig(item){
      // console.log(item);
      let y = Math.floor(item.id / this.round) * this.rowHeight
      let x = (item.id % this.round - 1) * this.columnWidth
      // console.log(item);
      return {
        x: x,
        y: y,
        width: this.columnWidth,
        height: this.rowHeight,
        fill: item.color,
        stroke: 'black',
      }
    },
    async fetchData( id = 0 ) {
      // this.data = ref()
      try {
          this.data = await axios.get(`/api/get/${id}`)
            .then( (res) => {
              this.line = res.data.raports.main.content
            });
          // this.line = this.data.raports.main.content
          // console.log(this.line);
      } catch (error) {
          // Do something with the error
          console.log(error);
      }
      // const res = await axios
      //   .get(`/api/get/${id}`)
      //   .then((result) => {
      //       console.log(result.data)
      //   })
      // console.log(this.res);
      // this.line = 
    }
    // chunk(arr, size) {
    //   Array.from({ length: Math.ceil(arr.length / size) }, (v, i) =>
    //     arr.slice(i * size, i * size + size)
    //   );
    // }
  },
  created () {
    this.pollData()
    this.fetchData();
    // this.drawRect()
    // window.addEventListener('keyup', this.tooglePlay())
  },
  // destroyed() {
  //   clearInterval(this.polling)
  // },
  components: { Button },
  setup() {
    onMounted(() => {

    })
    const { play } = useSound(drumSfx, {
      sprite: {
        black: [700, 1000],
        blue: [2200, 1000],
        brown: [3500, 1000],
        green: [5200, 1000],
        orange: [7100, 1000],
        pink: [8600, 1000],
        purple: [10000, 1000],
        red: [11600, 1000],
        white: [13300, 1000],
        yellow: [14700, 1000],
      },
    })
      // setInterval(() => {
      // // console.log()
      //   // play({ id: 'pink' })
      // }, 1010)
      // useKeyboardBindings({
        // 1: () => play({ id: 'black' }),
        // 2: () => play({ id: 'blue' }),
        // 3: () => play({ id: 'brown' }),
        // 4: () => play({ id: 'green' }),
        // 5: () => play({ id: 'orange' }),
        // 6: () => play({ id: 'pink' }),
        // 7: () => play({ id: 'purple' }),
        // 8: () => play({ id: 'red' }),
        // 9: () => play({ id: 'white' }),
        // 0: () => play({ id: 'yellow' }),
        // " ": () => {
        //   this.play = false
        // }
      // })
      // this.interval = setInterval(() => console.log(1), 3000);
    return {
      play,
    }
  },
  computed: {
    groupedItems() {
      return this.line
      console.log(this.chunk(this.line, this.round));
      // console.log(this.line[0].color);
      return this.line.slice().reverse()
    },
    bitmap() {
      console.log('render bitmap', this.line);

      // const initialValue = 0;
      var count = 0;
      const bitmap = this.line.reduce(
        (accumulator, currentValue) => {
          for(let i = 0; i <= currentValue.count; i++) {
            console.log(count);
            currentValue.id = count
            count++
            // console.log(currentValue);
            accumulator.push(currentValue);
          }
            
          return accumulator
        },
        [],
      );

      // console.log(sumWithInitial);
      return bitmap
    }
  }
}
</script>

<style>
  .active{
    border: 2px solid goldenrod;
  }
  .play {
    background-color: green;
    color: red;
  }
</style>