<template>
    <div>
        <div id="progressbar" class="mdl-progress mdl-js-progress"></div>

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
                    this.progressBar.setProgress(Math.round(100 * (this.current + 1) / this.cards.length));
                    if(this.current < this.cards.length - 1) {
                        this.current += 1;
                    } else {
                        this.endLessonSuccess();
                    }
                }, this.cardTimeout);
            },
        },
        components: {
            PlyCardTyped
        }
    }
</script>

<style>
    #progressbar {
        width: 100%;
        height: 6px;
    }
</style>
