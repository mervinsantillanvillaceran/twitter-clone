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
                    <form @submit.prevent="submit">
                        <div class="px-6 pt-6 bg-white">
                            <label for="message" class="leading-7 text-sm text-gray-600">Message</label>
                            <textarea v-model="form.text" name="message" class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                        </div>
                        <div class="px-6 pb-6 pt-2 float-right">
                            <button type="submit" class="text-white bg-blue-500 border-0 py-2 px-4 focus:outline-none hover:bg-blue-600 rounded" :class="{ 'opacity-50': disableBtn, ' cursor-not-allowed': disableBtn }">Save</button>
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
            tweet: Object,
        },
        data() {
            return {
                form : this.$inertia.form({
                    text: this.tweet.text
                }),
            }
        },
        methods: {
            submit() {
                if (this.disableBtn) return;
                this.form.put(this.route('tweets.update', this.tweet.id));
            }
        },
        computed: {
            disableBtn() {
                return this.form.text == ''
            }
        }
    }
</script>
