<template>
    <div>
        <header class="bg-white shadow mb-10">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold text-gray-900">Add Comment</h1>
            </div>
        </header>

        <div>
            <Link :href="route('comments.index')" class="text-indigo-600 hover:text-indigo-900 my-5 block">
                Back
            </Link>

            <form @submit.prevent="store" enctype="multipart/form-data">
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6">
                                <label class="block text-sm font-medium text-gray-700">Comment</label>
                                <input
                                    :class="{ 'border-red-500': form.errors.text }"
                                    v-model="form.text"
                                    type="text"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                />
                                <div class="text-red-500 mt-2" v-if="form.errors.text">{{ form.errors.text }}</div>
                            </div>
                            <input type="hidden" name="parent_id" :value="parent_id" />
                            <div class="col-span-6">
                                <label class="block text-sm font-medium text-gray-700">Image</label>
                                <input
                                    @change="handleFileChange"
                                    :class="{ 'border-red-500': form.errors.image }"
                                    type="file"
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                />
                                <div class="text-red-500 mt-2" v-if="form.errors.image">{{ form.errors.image }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button
                            type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-indigo-600 shadow-sm text-sm font-medium rounded-md text-indigo-600 hover:bg-indigo-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Add Comment
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import { useForm, Link } from "@inertiajs/inertia-vue3";

    export default {
        components: {
            Link,
        },

        props: {
            parent_id: {
                type: [Number, String],
                default: null,
            },
        },

        setup(props) {
            const form = useForm({
                text: null,
                image: null,
                parent_id: null,
            });

            form.parent_id = props.parent_id;

            function store() {
                if (!form.text) {
                    form.errors.text = !form.text ? "This field is required." : null;
                    return;
                }
                form.image = form.image || null;
                form.parent_id = form.parent_id || null;

                form.post(route("comments.store"));
            }

            function handleFileChange(event) {
                form.image = event.target.files[0];
            }

            return { form, store, handleFileChange };
        },
    };
</script>

