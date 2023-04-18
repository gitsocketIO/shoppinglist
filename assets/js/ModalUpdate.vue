<script>
    export default {
        props: {
            show: Boolean,
            nameToUpdate: String,
            logoToUpdate: String,
            idToUpdate: Number,
            indexToUpdate: Number,
        },
        data() {
            return {
                name: '',
                logo: ''
            }
        },
        mounted() {
            this.logo = this.logoToUpdate
        },
        methods: {
            getImgUrl(pic) {
                return require('../images/'+pic)
            },
        }
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
                        <div class="row row-cols-1">
                            <div class="mb-3 col">
                                <label for="inputName" class="text-uppercase, fw-bold">Nom de l'article</label>
                                <input type="text" v-bind:value="this.name = nameToUpdate" @input="this.name = $event.target.value" name="name" id="inputName" class="form-control" autocomplete="name" required>
                            </div>
                            <div class="mb-3 col">
                                <span class="text-uppercase, fw-bold">Choisissez le logo de votre article</span>
                            </div>
                        </div>
                        <div class="row row-cols-2">
                            <div class="col">
                                <input class="btn-check" type="radio" name="options-outlined" v-model="logo" value="banana.png" id="item-update-1" autocomplete="off" />
                                <label class="btn btn-outline-success" for="item-update-1">
                                    <img :src="getImgUrl('banana.png')" />
                                </label>
                            </div>
                            <div class="col">
                                <input class="btn-check" type="radio" name="options-outlined" v-model="logo" value="cherry.png" id="item-update-2" autocomplete="off" />
                                <label class="btn btn-outline-success" for="item-update-2">
                                    <img :src="getImgUrl('cherry.png')" />
                                </label>
                            </div>
                            <div class="col">
                                <input class="btn-check" type="radio" name="options-outlined" v-model="logo" value="grapes.png" id="item-update-3" autocomplete="off" />
                                <label class="btn btn-outline-success" for="item-update-3">
                                    <img :src="getImgUrl('grapes.png')" />
                                </label>
                            </div>
                            <div class="col">
                                <input class="btn-check" type="radio" name="options-outlined" v-model="logo" value="lemon.png" id="item-update-4" autocomplete="off" />
                                <label class="btn btn-outline-success" for="item-update-4">
                                    <img :src="getImgUrl('lemon.png')" />
                                </label>
                            </div>
                            <div class="col">
                                <input class="btn-check" type="radio" name="options-outlined" v-model="logo" value="oinion.png" id="item-update-5" autocomplete="off" />
                                <label class="btn btn-outline-success" for="item-update-5">
                                    <img :src="getImgUrl('oinion.png')" />
                                </label>
                            </div>
                            <div class="col">
                                <input class="btn-check" type="radio" name="options-outlined" v-model="logo" value="tomato.png" id="item-update-6" autocomplete="off" />
                                <label class="btn btn-outline-success" for="item-update-6">
                                    <img :src="getImgUrl('tomato.png')" />
                                </label>
                            </div>
                        </div>
                    </slot>
                    <div class="col-auto m-5">
                        <button class="btn btn-primary" @click="$emit('update-item', { id: idToUpdate, index: indexToUpdate, name: this.name, logo: this.logo })">Mettre à jour</button>
                    </div>
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