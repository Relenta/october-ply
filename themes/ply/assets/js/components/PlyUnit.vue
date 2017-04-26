<template>
  <div>
    <ply-card v-if="currentCard" :card="currentCard"></ply-card>
    <center>
      <ul class="pager">
        <li><a href="#" @click.prevent="current -= 1" v-if="current > 0">Previous</a></li>
        <li><a href="#" @click.prevent="current += 1" v-if="current < cards.length">Next</a></li>
      </ul>
    </center>
  </div>
</template>

<script>
  export default {
    props: ['id'],
    data() {
      return {
        cards: [],
        current: 0
      }
    },
    created() {
      axios.get('/learn').then(({data}) => {
        this.cards = data;
      });
    },
    computed: {
      currentCard() {
        return this.cards[this.current] || null;
      }
    }
  }
</script>