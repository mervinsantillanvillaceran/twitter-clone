<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Tweet
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <!-- <div v-if="hasErrors" class="px-6 pt-6">
                        <div class="font-medium text-red-600">Whoops! Something went wrong.</div>

                        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                            <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
                        </ul>
                    </div> -->
                    <form @submit="submit">
                        <div class="px-6 pt-6 bg-white">
                            <label for="message" class="leading-7 text-sm text-gray-600">Message</label>
                            <textarea v-model="form.text" name="message" class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                        </div>
                        <div class="px-6 pb-6 pt-2 float-right">
                            <button type="submit" class="text-white bg-blue-500 border-0 py-2 px-4 focus:outline-none hover:bg-blue-600 rounded">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'

    export default {
        components: {
            BreezeAuthenticatedLayout,
        },
        props: {
            tweet: Object
        },
        data() {
            return {
                form : this.$inertia.form({
                    text: this.tweet.text
                }),
            }
        },
        methods: {
            async submit(e) {
                e.preventDefault();
                this.form.put(this.route('tweets.update', this.tweet.id));
            }
        },
        // computed: {
        //     errors() {
        //         return this.$page.props?.errors;
        //     },
        //     hasErrors() {
        //         return Object.keys(this.errors).length > 0;
        //     },
        // }
    }
</script>
