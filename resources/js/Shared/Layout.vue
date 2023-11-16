<template>
    <div>
        <p v-if="$page.props.message" :class="{'hidden': !showMessage}" class="bg-indigo-600 h-10 flex items-center justify-center text-sm font-medium text-white px-4 sm:px-6 lg:px-8">
            {{ $page.props.message }}
            <span v-if="showMessage" @click.stop="closeMessage" class="cursor-pointer ml-2">×</span>
        </p>
    </div>

    <nav class="bg-gray-800">
        <div class="max-w-7xl mx-auto">
            <div class="relative flex items-center justify-between h-16">
                <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex space-x-4">
                        <a :href="route('home')" :class="{[activeClass]: isActive('home')}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            Home
                        </a>
                        <a :href="route('users.index')" :class="{[activeClass]: isActive('users')}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            UsersList
                        </a>
                        <a :href="route('comments.index')" :class="{[activeClass]: isActive('comments')}" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                            Comments
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>


    <div class="container mx-auto">
    <div v-if="$page.props.auth">
        {{ $page.props.auth.email }}

        <div>
            <a @click="logout" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mt-4">Logout</a>
        </div>
    </div>
        <div class="my-10">
            <slot />
        </div>
    </div>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3'

export default {
    components: {
        Link
    },
    data() {
        return {
            showMessage: true,
            activeClass: 'text-blue-500'
        };
    },
    methods: {
        isActive(route) {
            return this.route().current() === route || this.route().current().includes(route);
        },
        logout() {
            this.$inertia.delete(route('logout'))
        },
        closeMessage() {
            this.showMessage = false;
        },
    }
};
</script>

<style scoped>
    .hidden {
        display: none;
    }
</style>
