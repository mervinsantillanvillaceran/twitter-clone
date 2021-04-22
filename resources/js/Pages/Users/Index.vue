<template>
    <breeze-authenticated-layout>
        <template #header>
            <div  class="flex flex-row">
                <div  class="flex-auto">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Users
                    </h2>
                </div>
                <div class="flex flex-row">
                    <div class="mr-2">
                        <input type="text" v-model="search" class="h-8 border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm" placeholder="Search Users">
                        <button @click="searchUsers()" class="ml-2 text-white bg-red-500 border-0 py-1 px-2 focus:outline-none hover:bg-red-600 rounded">
                            Search
                        </button>
                    </div>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" v-if="users.length">
                <div v-for="user in users" :key="user.id" class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-2 flex">
                    <div class="flex-auto">
                        <div class="px-6 pt-6 bg-white">
                            {{ user.name }}
                        </div>
                        <div class="p-6 pt-2 bg-white text-gray-500">
                            {{ user.email }}
                        </div>
                    </div>
                    <div>
                        <div class="px-6 pt-6 bg-white">
                            <button v-if="!user.isFollowed" @click="follow(user.id)" class="text-white bg-gray-500 border-0 py-1 px-2 focus:outline-none hover:bg-gray-600 rounded text-sm">
                                Follow
                            </button>
                            <button v-if="user.isFollowed" @click="unfollow(user.id)"  class="ml-1 text-white bg-red-500 border-0 py-1 px-2 focus:outline-none hover:bg-red-600 rounded text-sm">
                                Unfollow
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
            users: Array,
            searchInput: String,
        },
        data() {
            return {
                search: (this.searchInput) ? this.searchInput : '',
            }
        },
        methods: {
            follow(user_id) {
                this.$inertia.post(this.route('followers.store', user_id));
            },

            unfollow(user_id) {
                this.$inertia.post(this.route('followers.destroy', user_id));
            },

            searchUsers() {
                this.$inertia.get(this.route('users.index', { search: this.search }));
            }
        }
    }
</script>
