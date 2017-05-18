<template>
    <div>
        <ply-card-flash 
            v-if="currentCard" 
            :card="currentCard" 
            @endCard="nextCard"
            :sideTimeout="sideTimeout">
        </ply-card-flash>
    </div>
</template>

<script>
    import PlyLearnBase from './PlyLearnBase.js';
    import PlyCardFlash from './PlyCardFlash';
    export default {
        props: ['cardTimeout', 'sideTimeout'],
        extends: PlyLearnBase,
        computed: {
            currentCard() {
                return this.cards[this.current] || null;
            }
        },
        methods: {
            nextCard() {
                setTimeout(() => {
                    if(this.current < this.cards.length - 1) {
                        this.current += 1;
                    } else {
                        this.current = 0;
                    }
                }, this.cardTimeout);
            },
        },
        components: {
            PlyCardFlash
        }
    }
</script>