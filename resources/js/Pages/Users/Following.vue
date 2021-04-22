<template>
    <breeze-authenticated-layout>
        <template #header>
            <div  class="flex flex-row">
                <div  class="flex-auto">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Following
                    </h2>
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
                            <inertia-link :href="`/messages/${user.id}`" class="text-white bg-indigo-500 border-0 py-1 px-2 focus:outline-none hover:bg-indigo-600 rounded text-sm">
                                Message
                            </inertia-link>
                            <button @click="unfollow(user.id)"  class="ml-1 text-white bg-red-500 border-0 py-1 px-2 focus:outline-none hover:bg-red-600 rounded text-sm">
                                Unfollow
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" v-else>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-2">
                    <div class="p-6 bg-white border-b border-gray-200">
                        No users found.
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
        },
        methods: {
            unfollow(user_id) {
                this.$inertia.post(this.route('followers.destroy', user_id));
            },
        }
    }
</script>
