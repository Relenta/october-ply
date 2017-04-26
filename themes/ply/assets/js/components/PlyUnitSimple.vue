<template>
  <div>
    <ply-card v-if="currentCard" :card="currentCard"></ply-card>
    <center>
      <ul class="pager">
        <li><a href="#" @click.prevent="current -= 1" v-if="current > 0">Previous</a></li>
        <li><a href="#" @click.prevent="current += 1" v-if="current < cards.length - 1">Next</a></li>
      </ul>
    </center>
  </div>
</template>

<script>
  import PlyUnit from './PlyUnit.js';

  export default {
    extends: PlyUnit,
    computed: {
      currentCard() {
        return this.cards[this.current] || null;
      }
    }
  }
</script>