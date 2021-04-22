<template>
    <breeze-authenticated-layout>
        <template #header>
            <div  class="flex flex-row">
                <div  class="flex-auto">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Tweet
                    </h2>
                </div>
                <!-- <div class="">
                    <inertia-link href="/tweets/create" class="text-white bg-blue-500 border-0 py-1 px-4 focus:outline-none hover:bg-blue-600 rounded">
                        New Tweet
                    </inertia-link>
                </div> -->
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-2 flex">
                    <div class="flex-auto">
                        <div class="px-6 pt-6 bg-white">
                            {{ tweet.text }}
                        </div>
                        <div class="p-6 pt-2 bg-white text-gray-500 text-sm">
                            👱🏼 Tweeted by {{ tweet.user.name }} ⏱ {{ formatDate(tweet.created_at) }}
                        </div>
                    </div>
                    <div>
                        <div class="px-6 pt-6 bg-white">
                            <inertia-link v-if="this.user.id == tweet.user_id" :href="`/tweets/${tweet.id}/edit`" class="ml-1 text-white bg-yellow-500 border-0 py-1 px-2 focus:outline-none hover:bg-yellow-600 rounded text-sm">
                                edit
                            </inertia-link>
                            <button v-if="this.user.id == tweet.user_id" @click="deleteTweet(tweet.id)" class="ml-1 text-white bg-red-500 border-0 py-1 px-2 focus:outline-none hover:bg-red-600 rounded text-sm">
                                delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-3">
                Comments:
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submitComment">
                        <div class="px-6 pt-6 bg-white">
                            <label for="message" class="leading-7 text-sm text-gray-600">Comment</label>
                            <textarea v-model="comment.message" name="message" class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 h-20 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                        </div>
                        <div class="px-6 pb-6 pt-2 float-right">
                            <button type="submit" class="text-white text-sm bg-blue-500 border-0 py-1 px-2 focus:outline-none hover:bg-blue-600 rounded">Add Comment</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" v-if="tweet.comments.length">
                <div v-for="comment in tweet.comments" :key="comment.id" class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-2 flex">
                    <div class="flex-auto">
                        <div class="px-6 pt-6 bg-white">
                            {{ comment.message }}
                        </div>
                        <div class="p-6 pt-2 bg-white text-gray-500 text-sm">
                            👱🏼 Commented by {{ comment.user.name }} ⏱ {{ formatDate(comment.created_at) }}
                        </div>
                    </div>
                    <!-- <div>
                        <div class="px-6 pt-6 bg-white">
                            <inertia-link v-if="this.user.id == comment.user_id" :href="`/tweets/${tweet.id}/edit`" class="ml-1 text-white bg-yellow-500 border-0 py-1 px-2 focus:outline-none hover:bg-yellow-600 rounded text-sm">
                                edit
                            </inertia-link>
                            <button v-if="this.user.id == comment.user_id" @click="deleteTweet(tweet.id)" class="ml-1 text-white bg-red-500 border-0 py-1 px-2 focus:outline-none hover:bg-red-600 rounded text-sm">
                                delete
                            </button>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" v-else>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-2">
                    <div class="p-6 bg-white border-b border-gray-200">
                        No tweets found.
                    </div>
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
    import { computed } from 'vue'
    import { usePage } from '@inertiajs/inertia-vue3'
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'
    import Swal from 'sweetalert2'

    export default {
        components: {
            BreezeAuthenticatedLayout,
        },
        props: {
            tweet: Object
        },
        data() {
            return {
                user: computed(() => usePage().props.value.auth.user),
                comment : this.$inertia.form({
                    message: ''
                }),
            }
        },
        methods: {
            formatDate(d) {
                const dd = new Date(d);
                return `${dd.getFullYear()}-${this.pad(dd.getMonth())}-${this.pad(dd.getDate())}`;
            },
            pad(n) {
                return String("00" + n).slice(-2);
            },
            submitComment() {
                this.comment.post(this.route('comments.store', this.tweet.id), {
                    onFinish: () => this.comment.reset('message'),
                });
            },
            deleteTweet(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Are you sure you want to delete this tweet?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$inertia.delete(this.route('tweets.destroy', id));
                    }
                })
            }
        }
    }
</script>
