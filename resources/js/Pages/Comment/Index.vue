<template>
    <div>
        <Head :title="title" />

        <header class="bg-white shadow mb-10">
            <div class="px-4 mx-auto py-6 flex justify-between">
                <h1 class="text-3xl font-bold text-gray-900">{{ title }}</h1>
                <Link
                    :href="route('comments.create')"
                    class="border border-blue-500 text-blue-500 hover:border-blue-700 hover:text-blue-700 py-2 px-4 rounded inline-block mb-4"
                >
                    Add comment
                </Link>
            </div>
        </header>

        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div v-if="commentsByData.total > 0">
                        <!-- Iterate through all comments -->
                        <Comment
                            v-for="comment in filteredComments"
                            :key="comment.id"
                            :comment="comment"
                            :users="users"
                            @destroy="destroy"
                            @toggleReplies="toggleReplies"
                            :depth="0"
                            :numReplies="getNumberOfReplies(comment.id)"
                            :replies="getRepliesForComment(comment.id)"
                        />

                        <Pagination :links="commentsByData.links" />
                    </div>

                    <div v-else class="text-center text-xl text-gray-700 my-10">
                        There are no comments yet
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Pagination from '../../Shared/Pagination';
    import moment from 'moment';
    import Comment from './Comment.vue';

    export default {
        components: {
            Head,
            Link,
            Pagination,
            Comment,
        },
        props: {
            title: String,
            commentsByData: Object,
            comments: Object,
            users: Object,
        },
        data() {
            return {
                replies: [],
            };
        },
        computed: {
            filteredComments() {
                return this.commentsByData.data.filter(comment => comment.parent_id === null);
            },
        },
        methods: {
            formattedDate(date) {
                return moment(date).format('DD.MM.YY [в] HH:mm');
            },

            destroy(id) {
                if (confirm('Are you sure?')) {
                    this.$inertia.delete(this.route('comments.destroy', id));
                }
            },

            toggleReplies(commentId) {
                if (this.replies.includes(commentId)) {
                    this.replies = this.replies.filter(id => id !== commentId);
                } else {
                    this.replies.push(commentId);
                }
            },

            getNumberOfReplies(parentId) {
                return this.commentsByData.data.filter(comment => comment.parent_id === parentId).length;
            },

            getRepliesForComment(commentId) {
                return this.commentsByData.data.filter(comment => comment.parent_id === commentId);
            },
        },
    };
</script>

<style>
    .group-container {
        display: inline-block;
        max-width: 100%;
    }

    .group:hover .rounded {
        border: 2px solid #FFA500;
    }
</style>
