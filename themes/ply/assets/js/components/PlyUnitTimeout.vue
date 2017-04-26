<template>
    <div>
        <ply-card v-if="currentCard" :card="currentCard"></ply-card>
    </div>
</template>

<script>
    import PlyUnit from './PlyUnit.js';
    export default {
        props: ['timeout'],
        extends: PlyUnit,
        computed: {
            currentCard() {
                return this.cards[this.current] || null;
            }
        },
        mounted() {
            window.setInterval(() => {
                this.nextCard();
            }, this.timeout);
        },
        methods: {
            nextCard() {
                if(this.current < this.cards.length - 1) {
                    this.current += 1;
                } else {
                    this.current = 0;
                }
            }
        }
    }
</script>