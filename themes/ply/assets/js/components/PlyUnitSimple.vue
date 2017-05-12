<template>
    <div>
        <ply-card v-if="currentCard" :card="currentCard"></ply-card>

        <center>
            <button @click.prevent="current -= 1" v-if="current > 0" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Previous card</button>
            <button @click.prevent="current += 1" v-if="current < cards.length - 1" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Next card</button>
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