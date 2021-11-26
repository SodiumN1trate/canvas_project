<template>
  <div class="home">
<!--      <h1>Drawing app</h1>-->
      <canvas id="canvas" @mousedown="startDraw" @mouseup="finishDraw" @mousemove="draw" width="700" height="500"></canvas> <!-- Molberta lauks :D -->
      <br />
      <button @click.prevent="save_image">Save</button>
      <div>
        <img :src="image_code">
      </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'Home',
  data: function () {
    return {
      ctx: null,
      drawing: false,
      cRect: null,
      canvas: null,
      image_code: null
    }
  },
  mounted: function() {
    let canvas = document.getElementById("canvas")
    let ctx = canvas.getContext('2d')
    this.canvas = canvas
    this.ctx = ctx
    canvas.height = 500
    canvas.width = 700
    this.cRect = canvas.getBoundingClientRect()
  },
  methods: {
    startDraw: function () {
      this.drawing = true
      this.ctx.beginPath()
      console.log("Starting drawing")
    },
    finishDraw: function () {
      this.drawing = false
      console.log("Finishing drawing")
    },
    draw: function (e) {
      if(this.drawing == false) return
      this.ctx.lineCap = "round"
      this.ctx.strokeStyle = 'red'
      this.ctx.lineWidth = 10

      this.ctx.lineTo(e.clientX - this.cRect.left, e.clientY - this.cRect.top)
      this.ctx.stroke()

      this.ctx.beginPath()
      this.ctx.moveTo(e.clientX - this.cRect.left, e.clientY - this.cRect.top)
    },
    save_image: function () {
      var image = new Image()
      image.src = this.canvas.toDataURL() // No canvas izveido base64 kodu
      axios.post(process.env.VUE_APP_SERVER_URL + "/save_canvas", {image: image.src}).then(response => {
        this.image_code = response.data.image
      }) // base64 kodu aizsūta uz serveri, kur tiek saglabāta tā bilde failā, atrgiež bildi
    }
  }
}


</script>


<style>
#canvas {
  border: 2px solid black;
  border-radius: 10px;
}
</style>