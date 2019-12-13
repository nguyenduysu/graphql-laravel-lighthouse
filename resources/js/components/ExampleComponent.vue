<template>
    <h1>Example Component</h1>
</template>

<script>
    import gql from "graphql-tag";
    const GET_USERS = gql `
        query allUsers {
            allUsers {
                id
                name
                email
            }
        }
    `;
    export default {
        mounted() {
            Echo.join(`chat`)
                .here((users) => {
                    console.log(users); /* eslint-disable-line no-console */
                })
                .joining((user) => {
                    console.log(user.name + " joined"); /* eslint-disable-line no-console */
                })
                .leaving((user) => {
                    console.log(user.name + " leave"); /* eslint-disable-line no-console */
                });
        },
        data() {
            return {
                users: []
            };
        },
        apollo: {
            allUsers: {
                query: GET_USERS,
                result({data}) {
                    console.log(data); /* eslint-disable-line no-console */
                }
            }
        }
    }
</script>
