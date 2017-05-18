<template>
    <div>
        <ply-card-typed
            v-if="currentCard" 
            :card="currentCard" 
            @endCard="nextCard"
            :sideTimeout="sideTimeout">
        </ply-card-typed>
    </div>
</template>

<script>
    import PlyLearnBase from './PlyLearnBase.js';
    import PlyCardTyped from './PlyCardTyped';
    
    export default {
        props: ['cardTimeout', 'sideTimeout'],
        extends: PlyLearnBase,
        data() {
            return {
                answer: ''
            }
        },
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
            PlyCardTyped
        }
    }
</script>