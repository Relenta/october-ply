export default {
    props: ['course_id', 'unit_id'],
    data() {
        return {
            cards: [],
            current: 0
        }
    },
    created() {
        axios.get(`/api/v1/learn?${location.search}`).then(({data}) => {
            this.cards = data;
        });
    }
}