<template>
    <div>
        <div class="p-4 border border-gray-300 rounded" :style="{ marginLeft: `${depth * 20}px` }">
            <div class="text-lg text-gray-700 mb-2">{{ comment.text }}</div>
            <div class="text-sm text-gray-500 flex justify-between items-center">
                <div class="flex items-center">
                    <span class="mr-2 font-bold">{{ this.users[comment.user_id]?.name }}</span>
                    {{ formattedDate(comment.created_at) }}
                </div>
                <div class="flex gap-2">
                    <div>
                        <button
                            @click="toggleReplies(comment.id)"
                            :style="{ display: numReplies > 0 ? '' : 'none' }"
                            class="border border-blue-500 text-blue-500 hover:border-blue-700 hover:text-blue-700 py-1 px-4 rounded inline-block ml-2"
                        >
                            Comments ({{ numReplies }})
                        </button>
                    </div>
                    <a
                        :href="route('comments.create', { parent_id: comment.id })"
                        class="border border-blue-500 text-blue-500 hover:border-blue-700 hover:text-blue-700 py-1 px-4 rounded inline-block ml-2"
                    >
                        Answer
                    </a>
                    <a
                        @click="destroy(comment.id)"
                        class="action-button border border-red-500 text-red-600 hover:text-red-900 cursor-pointer py-1 px-4 rounded inline-block"
                    >
                        Delete
                    </a>
                </div>
            </div>

            <div v-if="comment.image" class="group-container mt-4">
                <div class="group relative">
                    <img
                        :src="comment.image"
                        alt="Comment Image"
                        class="rounded border-2 border-transparent transition duration-300 ease-in-out group-hover:border-orange-500"
                        style="max-width: 100%"
                    />
                </div>
            </div>

<!--            <div v-if="replies.includes(comment.id)">-->
<!--                <Comment-->
<!--                    v-for="childComment in comment.children || replies[comment.id]"-->
<!--                    :key="childComment.id"-->
<!--                    :comment="childComment"-->
<!--                    :users="users"-->
<!--                    @destroy="destroy"-->
<!--                    :depth="depth + 1"-->
<!--                    :numReplies="getNumberOfReplies(childComment.id)"-->
<!--                    :replies="replies"-->
<!--                    @toggleReplies="toggleReplies"-->
<!--                />-->
<!--            </div>-->
        </div>
    </div>
</template>

<script>
    import moment from 'moment';

    export default {
        props: {
            comment: Object,
            users: Object,
            numReplies: Number,
            replies: Object,
            depth: {
                type: Number,
                default: 0,
            },
        },
        methods: {
            formattedDate(date) {
                return moment(date).format('DD.MM.YY [в] HH:mm');
            },
            destroy(id) {
                this.$emit('destroy', id);
            },
            toggleReplies(commentId) {
                this.$emit('toggleReplies', commentId);
            },
            getNumberOfReplies(comment) {
                return comment.children ? comment.children.length : 0;
            },
        },
    };
</script>

<style scoped>
    .group-container {
        display: inline-block;
        max-width: 100%;
    }

    .group:hover .rounded {
        border: 2px solid #FFA500;
    }
</style>
