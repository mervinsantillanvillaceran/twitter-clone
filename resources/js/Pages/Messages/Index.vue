<template>
    <breeze-authenticated-layout>
        <template #header>
            <div  class="flex flex-row">
                <div  class="flex-auto">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        Messages
                    </h2>
                    <span class="text-gray-500">{{ sentTo.name }} ({{ sentTo.email }})</span>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" v-if="messages.length">
                <div v-for="message in messages" :key="message.id" class="overflow-hidden shadow-sm sm:rounded-lg mb-2" :class="(message.sender_id == user.id) ? 'bg-blue-300' : 'bg-white'">
                    <div>
                        <div class="px-6 pt-6">
                            {{ message.message }}
                        </div>
                        <div class="p-6 pt-2 text-gray-500 text-sm">
                            ⏱ {{ formatDate(message.created_at) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="sendMessage">
                        <div class="px-6 pt-6 bg-white">
                            <label for="message" class="leading-7 text-sm text-gray-600">Message</label>
                            <textarea v-model="form.message" name="message" class="w-full bg-white rounded border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 h-20 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                        </div>
                        <div class="px-6 pb-6 pt-2 float-right">
                            <button type="submit" class="text-white text-sm bg-blue-500 border-0 py-1 px-2 focus:outline-none hover:bg-blue-600 rounded" > Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
    import { computed } from 'vue'
    import { usePage } from '@inertiajs/inertia-vue3'
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'

    export default {
        components: {
            BreezeAuthenticatedLayout,
        },
        props: {
            sentTo: Object,
            messages: Array
        },
        data() {
            return {
                user: computed(() => usePage().props.value.auth.user),
                form : this.$inertia.form({
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
            sendMessage() {
                this.form.post(this.route('messages.store', this.sentTo.id), {
                    onFinish: () => this.form.reset('message'),
                });
            }
        },
    }
</script>
