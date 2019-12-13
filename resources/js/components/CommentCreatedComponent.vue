<template>
    <h1>Comment Created</h1>
</template>

<script>
    import gql from 'graphql-tag';

    export default {
        name: "CommentCreatedComponent.vue",
        mounted() {
            console.log('Component mounted');
            Echo.private('App.User.' + '1')
                .notification((notification) => {
                    console.log(notification);
                });
        },
        data() {
            return {
                comment: ''
            };
        },
        apollo: {
            $subscribe: {
                subscribe: {
                    query: gql`
                        subscription commentCreated($id: ID) {
                            commentCreated(id: $id) {
                                id
                                reply
                                user {
                                    id
                                    name
                                }
                            }
                        }
                    `,
                    variables() {
                        return {
                            id: this.id,
                        }
                    },
                    result({data}) {
                        this.comment = data.commentCreated;
                        console.log(data); /* eslint-disable-line no-console */
                    },
                },
            },
        },
    }
</script>

<style scoped>

</style>
