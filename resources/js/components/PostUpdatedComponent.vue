<template>
    <h1>Post Updated 12</h1>
</template>

<script>
    import gql from 'graphql-tag';
    export default {
        name: "PostUpdatedComponent.vue",
        data() {
            return {
                post: ''
            };
        },
        apollo: {
            $subscribe: {
                subscribe: {
                    query: gql `
                        subscription postUpdated($id: ID) {
                            postUpdated(id: $id) {
                                id
                                title
                                content
                            }
                        }
                    `,
                    variables() {
                        return {
                            id: this.id,
                        }
                    },
                    result({data}) {
                        this.post = data.postUpdated;
                        console.log(data); /* eslint-disable-line no-console */
                    },
                },
            },
        },
    };
</script>

<style scoped></style>
