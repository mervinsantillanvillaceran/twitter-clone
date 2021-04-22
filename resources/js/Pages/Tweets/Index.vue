<template>
    <breeze-authenticated-layout>
        <template #header>
            <div  class="flex flex-row">
                <div  class="flex-auto">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Timeline
                    </h2>
                </div>
                <div class="flex flex-row">
                    <div class="mr-2">
                        <input type="text" v-model="search" class="h-8 border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm" placeholder="Search Tweets">
                        <button @click="searchTweets()" class="ml-2 text-white bg-red-500 border-0 py-1 px-2 focus:outline-none hover:bg-red-600 rounded">
                            Search
                        </button>
                    </div>
                    <inertia-link href="/tweets/create" class="text-white bg-blue-500 border-0 py-1 px-4 focus:outline-none hover:bg-blue-600 rounded">
                        New Tweet
                    </inertia-link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" v-if="tweets.length">
                <div v-for="tweet in tweets" :key="tweet.id" class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-2 flex">
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
                            <inertia-link :href="`/tweets/${tweet.id}`" class="text-white bg-gray-500 border-0 py-1 px-2 focus:outline-none hover:bg-gray-600 rounded text-sm">
                                show
                            </inertia-link>
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
            searchInput: String,
            tweets: Array
        },
        data() {
            return {
                user: computed(() => usePage().props.value.auth.user),
                search: (this.searchInput) ? this.searchInput : '',
            }
        },
        methods: {
            searchTweets() {
                this.$inertia.get(this.route('tweets.index'), { search : this.search });
            },
            formatDate(d) {
                const dd = new Date(d);
                return `${dd.getFullYear()}-${this.pad(dd.getMonth())}-${this.pad(dd.getDate())}`;
            },
            pad(n) {
                return String("00" + n).slice(-2);
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
