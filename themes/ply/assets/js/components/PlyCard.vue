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
        props: ['card']
    }
</script>