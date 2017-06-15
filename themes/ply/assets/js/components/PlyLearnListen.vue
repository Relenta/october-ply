<template>
    <div class="mdl-grid ply-learn-container">
        <ply-card-listen
            v-if="currentCard"
            :card="currentCard"
            :sideTimeout="sideTimeout"
            @endCard="nextCard">
        </ply-card-listen>

        <div class="mdl-cell--4-col learn-sidebar">
            <div class="description mdl-shadow--2dp" style="background-image: url('/themes/ply/assets/images/bg-flags/uk.jpg');">
                <h1 class="course-title">Course title</h1>
                <div class="spacer"></div>
                <h2 class="unit-title">Unit title</h2>
            </div>
            <div class="progress-container">
                <h3>Your progress:</h3>
                <div id="progressbar" class="mdl-progress mdl-js-progress learn-progressbar"></div>
                <div class="percent"><span class="number">{{ progress }}</span>%</div>
            </div>
        </div>
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
                        let _percent = Math.round(100 * this.current / this.count);
                        this.updateProgress(_percent);
                    } else {
                        this.updateProgress(100);
                        setTimeout(this.endLessonSuccess, 500);
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
