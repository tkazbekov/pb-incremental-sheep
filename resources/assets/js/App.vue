<template>
  <div class="container">
    <h1>Welcome to the Sheep Farm</h1>
    <span class="badge badge-secondary">Seconds: {{seconds}}</span>
    <span class="badge badge-secondary">Day: {{days}}</span>
    <span class="badge badge-secondary">Next sacrifice: {{10 - (days % 10)}}</span>
    <span class="badge badge-secondary">Total sheeps: {{sheepcount}}</span>
    <div class="row">
      <pen v-for="pen in pens" :key="pen.id" :pen="pen"></pen>
    </div>
  </div>
</template>

<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter,
.fade-leave-active {
  opacity: 0;
}
</style>

<script>
import Pen from "./components/Pen.vue";
import Axios from "axios";
export default {
  components: {
    Pen
  },
  data() {
    return {
      pens: [],
      sheeps: [],
      sheepcount: 0,
      seconds: 0,
      days: 0,
      lastKilled: ""
    };
  },
  methods: {
    initialize() {
      this.getAllPens()
        .then(() => this.getAllSheeps())
        .then(() => this.iterate());
    },

    getAllSheeps() {
      let sheepsURL = "/api/sheeps";
      return this.axios.get(sheepsURL).then(({ data }) => {
        this.sheepcount = data.total_sheeps;
        if (data.data.length > 0) this.sheeps = data.data;
        else this.fillPens();
      });
    },

    getAllPens() {
      let pensURL = "/api/pens";
      return this.axios.get(pensURL).then(({ data }) => {
        data.data.length > 0 ? (this.pens = data.data) : this.createPen(4);
      });
    },

    createPen(amount) {
      let pensURL = "/api/pens";
      return this.axios
        .post(pensURL, { create_amount: amount })
        .then(({ data }) => {
          this.pens = data.data;
        });
    },

    createSheep(pens) {
      let url = "/api/sheeps";
      let birthingPen = pens[this.getRandomInt(0, pens.length)];
      console.log(birthingPen);
      this.axios.post(url, { pen_id: birthingPen.id }).then(({ data }) => {
        this.sheeps.push(data.data);
        this.sheepcount++;
        birthingPen.sheeps++;
      });
    },

    moveSheep(pen) {
      let url = "/api/sheeps";
      let biggestPen = this.sheeps.filter(
        sheep => sheep.pen_id == this.getRichestPen().id
      );
      let randInt = this.getRandomInt(0, biggestPen.length);
      let target = biggestPen[randInt];
      this.axios.put(`${url}/${target.id}`, { pen_id: pen.id }).then(data => {
        console.log(biggestPen.indexOf(target));
        pen.sheeps++;
        // biggestPen.splice(biggestPen.indexOf(target), 1)
      });
    },

    kill() {
      let url = "/api/sheeps";
      let randInt = this.getRandomInt(0, this.sheeps.length);
      let target = this.sheeps[randInt];

      this.axios.delete(`${url}/${target.id}`).then(() => {
        this.sheeps = this.sheeps.filter(sheep => sheep.id != target.id);
        this.pens.find(pen => pen.id == target.pen_id).sheeps--;
      });
    },

    getRandomInt(min, max) {
      min = Math.ceil(min);
      max = Math.floor(max);
      return Math.floor(Math.random() * (max - min)) + min;
    },

    getRichestPen() {
      let max = this.pens[0];
      return this.pens.reduce(
        (max, pen) => (pen.sheeps > max.sheeps ? pen : max)
      );
    },

    iterate() {
      this.seconds++;

      if (this.seconds % 3 === 0) {
        this.pens.filter(pen => pen.sheeps < 2).map(pen => this.moveSheep(pen));
        let filteredPens = this.pens.filter(pen => pen.sheeps >= 2);
        
        this.days++;
        this.createSheep(filteredPens);
        if (this.days % 3 === 0) {
          this.kill();
        }
      }

      setTimeout(this.iterate, 1000);
    }
  },

  created() {
    this.initialize();
  }
};
</script>