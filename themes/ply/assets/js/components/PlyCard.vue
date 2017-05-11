<template>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="well">
                <h3>{{ card.sides[0].content }}</h3>
                <hr>
                <h3>{{ card.sides[1].content }}</h3>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['card'],
        watch: {
            card() {
                this.playCardMedia();
            }
        },
        methods: {
            playCardMedia() {
                if(!this.side_1.media) return;
                let media_1 = new Audio(this.side_1.media.path);
                media_1.onended = this.playSecondMedia;
                media_1.play();
            },
            playSecondMedia() {
                if(!this.side_2.media) return;
                let media_2 = new Audio(this.side_2.media.path);
                media_2.play();
            }
        },
        computed: {
            side_1() {
                return this.card.sides[0] || null;
            },
            side_2() {
                return this.card.sides[1] || null;
            }
        }
    }
</script>