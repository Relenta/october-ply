<template>
    <div>
        <ply-card-listen
            v-if="currentCard" 
            :card="currentCard" 
            :sideTimeout="sideTimeout"
            @endCard="nextCard">
        </ply-card-listen>

        <center>
            <button 
                    v-if="playing"
                    @click="playing = ! playing" 
                    class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
            Pause
            </button>
            <button 
                    v-if="!playing"
                    @click="resume" 
                    class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
            Resume
            </button>
        </center>
    </div>
</template>

<script>
    import PlyLearnBase from './PlyLearnBase.js';
    import PlyCardListen from './PlyCardListen';
    export default {
        props: ['cardTimeout', 'sideTimeout'],
        extends: PlyLearnBase,
        data() {
            return {
                playing: true
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
                    if(!this.playing) return;
                    if(this.current < this.cards.length - 1) {
                        this.current += 1;
                    } else {
                        this.current = 0;
                    }
                }, this.cardTimeout);
            },
            resume() {
                this.playing = true;
                this.nextCard();
            }
        },
        components: {
            PlyCardListen
        }
    }
</script>