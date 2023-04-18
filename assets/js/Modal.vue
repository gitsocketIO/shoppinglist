<script>
    export default {
        props: {
            show: Boolean
        },
        data() {
            return {
                name: '',
                logo: ''
            }
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
                    <slot name="body" class="text-center">
                        <div class="row row-cols-1">
                            <div class="mb-3 col">
                                <label for="inputName" class="text-uppercase, fw-bold">Nom de l'article</label>
                                <input type="text" v-model="name" name="name" id="inputName" class="form-control" autocomplete="name" required>
                            </div>
                            <div class="mb-3 col">
                                <span>Choisissez le logo de votre article</span>
                            </div>
                        </div>
                        <div class="row row-cols-2">
                            <div class="col">
                                <input class="btn-check" type="radio" name="options-outlined" v-model="logo" value="banana.png" id="item-1" autocomplete="off" />
                                <label class="btn btn-outline-success" for="item-1">
                                    <img :src="getImgUrl('banana.png')" />
                                </label>
                            </div>
                            <div class="col">
                                <input class="btn-check" type="radio" name="options-outlined" v-model="logo" value="cherry.png" id="item-2" autocomplete="off" />
                                <label class="btn btn-outline-success" for="item-2">
                                    <img :src="getImgUrl('cherry.png')" />
                                </label>
                            </div>
                            <div class="col">
                                <input class="btn-check" type="radio" name="options-outlined" v-model="logo" value="grapes.png" id="item-3" autocomplete="off" />
                                <label class="btn btn-outline-success" for="item-3">
                                    <img :src="getImgUrl('grapes.png')" />
                                </label>
                            </div>
                            <div class="col">
                                <input class="btn-check" type="radio" name="options-outlined" v-model="logo" value="lemon.png" id="item-4" autocomplete="off" />
                                <label class="btn btn-outline-success" for="item-4">
                                    <img :src="getImgUrl('lemon.png')" />
                                </label>
                            </div>
                            <div class="col">
                                <input class="btn-check" type="radio" name="options-outlined" v-model="logo" value="oinion.png" id="item-5" autocomplete="off" />
                                <label class="btn btn-outline-success" for="item-5">
                                    <img :src="getImgUrl('oinion.png')" />
                                </label>
                            </div>
                            <div class="col">
                                <input class="btn-check" type="radio" name="options-outlined" v-model="logo" value="tomato.png" id="item-6" autocomplete="off" />
                                <label class="btn btn-outline-success" for="item-6">
                                    <img :src="getImgUrl('tomato.png')" />
                                </label>
                            </div>
                        </div>

                        <div class="col-auto m-5">
                            <button class="btn btn-primary" @click="$emit('submit-item', { name: this.name, logo: this.logo })">Ajouter</button>
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