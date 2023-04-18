<script>
    export default {
        name: "ModalSharing",
        props: {
            show: Boolean,
            idToSharing: Number,
            userId: String,
        },
        data() {
            return {
                selected: '',
                users_list: []
            }
        },
        mounted() {
            this.getUsersList();
        },
        computed: {
            getOtherUsers: function () {
                return this.users_list.filter(i => i.id !== parseInt(this.userId))
            },
        },
        methods: {
            async getUsersList() {
                try {
                    const items = await fetch("/api/users.json", {"method": "GET"})
                    this.users_list = await items.json();
                } catch (err) {
                    console.error('Can\'t get items data', err);
                }
            },
            async setSharingItem() {
                try {
                    if (this.selected !== '') {
                        const requestOptions = {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ user: '/api/users/' + this.selected, item: '/api/items/' + this.idToSharing, shoppingSharingUser: { user: '/api/users/' + this.userId } })
                        };
                        const items = await fetch("/api/share items.json", requestOptions)
                        await items.json();
                        this.$emit('update-item');
                    }
                } catch (err) {
                    console.error('Can\'t add sharing data', err);
                }
            },
        },
    }
</script>

<template>
    <Transition name="modal">
        <div v-if="show" class="modal-mask">
            <div class="modal-container">
                <div class="modal-header">
                    <slot name="header">default header</slot>
                </div>

                <div class="modal-body">
                    <slot name="body">
                        <div class="mb-3">
                            <select class="form-select" v-model="selected">
                                <option v-for="user in getOtherUsers" v-bind:value="user.id">
                                    {{ user.username }}
                                </option>
                            </select>
                        </div>
                        <div class="col-auto m-5">
                            <button class="btn btn-primary" @click="this.setSharingItem()">Partager</button>
                        </div>
                    </slot>
                </div>

                <div class="modal-footer">
                    <slot name="footer">
                        <button
                                class="btn btn-primary"
                                @click="$emit('close')"
                        >Fermer</button>
                    </slot>
                </div>
            </div>
        </div>
    </Transition>
</template>