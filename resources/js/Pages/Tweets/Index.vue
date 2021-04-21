<template>
    <breeze-authenticated-layout>
        <template #header>
            <div  class="flex flex-row">
                <div  class="flex-auto">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Timeline
                    </h2>
                </div>
                <div class="">
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
                        <div class="p-6 pt-2 bg-white text-gray-500">
                            {{ formatDate(tweet.created_at) }}
                        </div>
                    </div>
                    <div>
                        <div class="px-6 pt-6 bg-white">
                            <inertia-link :href="`/tweets/${tweet.id}/edit`" class="text-white bg-yellow-500 border-0 py-1 px-2 focus:outline-none hover:bg-yellow-600 rounded text-sm">
                                edit
                            </inertia-link>
                            <button class="ml-1 text-white bg-red-500 border-0 py-1 px-2 focus:outline-none hover:bg-red-600 rounded text-sm">
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
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'

    export default {
        components: {
            BreezeAuthenticatedLayout,
        },
        props: {
            tweets: Array
        },
        methods: {
            formatDate(d) {
                const dd = new Date(d);
                return `${dd.getFullYear()}-${this.pad(dd.getMonth())}-${this.pad(dd.getDate())}`;
            },
            pad(n) {
                return String("00" + n).slice(-2);
            }
        }
    }
</script>
