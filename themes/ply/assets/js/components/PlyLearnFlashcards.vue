<template>
    <div>
        <ply-card-flash 
            v-if="currentCard" 
            :card="currentCard" 
            @endCard="nextCard">
        </ply-card-flash>
    </div>
</template>

<script>
    import PlyLearnBase from './PlyLearn.js';

    export default {
        extends: PlyLearnBase,
        computed: {
            currentCard() {
                return this.cards[this.current] || null;
            }
        },
        methods: {
            nextCard() {
                if(this.current < this.cards.length - 1) {
                    this.current += 1;
                } else {
                    this.current = 0;
                }
            },
        }
    }
</script>