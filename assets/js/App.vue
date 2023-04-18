<script>
    import Modal from "./Modal";
    import ModalUpdate from "./ModalUpdate";
    import ModalSharing from "./ModalSharing";

    /* import the fontawesome core */
    import { library } from '@fortawesome/fontawesome-svg-core'

    /* import font awesome icon component */
    import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

    /* import specific icons */
    import { faRightFromBracket } from '@fortawesome/free-solid-svg-icons'
    import { faCirclePlus } from '@fortawesome/free-solid-svg-icons'
    import { faPenToSquare } from '@fortawesome/free-solid-svg-icons'
    import { faShare } from '@fortawesome/free-solid-svg-icons'
    import { faTrash } from '@fortawesome/free-solid-svg-icons'
    import { faUser } from '@fortawesome/free-solid-svg-icons'
    import { faTrashCanArrowUp } from '@fortawesome/free-solid-svg-icons'
    import {nextTick} from "@vue/runtime-core";

    /* add icons to the library */
    library.add(faRightFromBracket, faCirclePlus, faPenToSquare, faShare, faTrash, faUser, faTrashCanArrowUp);

    export default {
        components: {
            ModalUpdate,
            ModalSharing,
            Modal,
            FontAwesomeIcon,
        },
        created() {

        },
        computed: {
            listId() {
                return window.listId;
            },
            userId() {
                return window.userId;
            },
        },
        data() {
            return {
                show: true,
                showModal: false,
                showModalUpdate: false,
                showModalSharing: false,
                nameToUpdate: '',
                logoToUpdate: '',
                idToUpdate: 0,
                indexToUpdate: 0,
                idToSharing: 0,
                items_list: [],
                sharing_list: []
            }
        },
        mounted() {
            this.getItemsList();
            this.getSharingList();
        },
        methods: {
            async getItemsList() {
                try {
                    const items = await fetch("/api/items.json?list=%2Fapi%2Flists%2F" + listId, {"method": "GET"})
                    this.items_list = await items.json();
                } catch (err) {
                    console.error('Can\'t get items data', err);
                }
            },
            async getSharingList() {
                try {
                    const items = await fetch("/api/share items.json?user=%2Fapi%2Fuser%2F" + userId, {"method": "GET"})
                    this.sharing_list = await items.json();
                } catch (err) {
                    console.error('Can\'t get sharing data', err);
                }
            },
            async onSubmitItem(event) {
                try {
                    const requestOptions = {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ name: event.name, logo: event.logo, list: '/api/lists/' + listId })
                    };
                    const items = await fetch("/api/items.json", requestOptions)
                    let data = await items.json();
                    await this.getItemsList();
                } catch (err) {
                    console.error('Can\'t add items data', err);
                }
            },
            async removeItem(id) {
                try {
                    await fetch("/api/items/" + id + ".json", {"method": "DELETE"})
                    await this.getSharingList();
                    await this.getItemsList();
                } catch (err) {
                    console.error('Can\'t delete items data', err);
                }
            },
            async removeSharingItem(idItemSharing) {
                try {
                    await fetch("/api/share items/" + idItemSharing + ".json", {"method": "DELETE"})
                    await this.getItemsList();
                } catch (err) {
                    console.error('Can\'t delete sharing items data', err);
                }
            },
            getImgUrl(pic) {
                return require('../images/'+pic)
            },
            callUpdateModal(id, index, name, logo) {
                this.idToUpdate = id;
                this.indexToUpdate = index;
                this.nameToUpdate = name;
                this.logoToUpdate = logo;
                this.showModalUpdate = true;
                this.updateComponent();
            },
            callSharingModal(id) {
                this.idToSharing = id;
                this.showModalSharing = true;
                this.updateComponent();
            },
            async onUpdateItem(event) {
                try {
                    if (event.name !== '' && event.logo !== '') {
                        const requestOptions = {
                            method: 'PUT',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ name: event.name, logo: event.logo, list: '/api/lists/' + listId })
                        };
                        const items = await fetch("/api/items/" + event.id + ".json", requestOptions)
                        await this.getSharingList();
                        await this.getItemsList();
                    }
                    this.showModalUpdate = false;
                } catch (err) {
                    console.error('Can\'t update items data', err);
                }
            },
            updateComponent() {
                let self = this;
                self.show = false;

                nextTick(function (){
                    self.show = true;
                })

            }
        }
    }
</script>

<template>
    <nav class="navbar bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/home">
                <img :src="getImgUrl('panier.png')" style="height: 50px;" alt="Shopping list logo">
                <span class="navbar-brand mb-0 h1 text-light">Ma liste de Course</span>
            </a>
            <a class="d-flex btn btn-danger" href="/logout">
                <span class="text-light p-1">Se déconnecter</span>
                <span class="m-1"><font-awesome-icon class="text-light" icon="fa-solid fa-right-from-bracket" /></span>
            </a>
        </div>
    </nav>
    <div class="container-fluid overflow-hidden text-center" v-if="show">
        <div class="row">
            <div class="col text-center">
                <img :src="getImgUrl('panier.png')" class="img-fluid" alt="Shopping list logo">
            </div>
        </div>
        <div class="row">
            <div class="col text-center mt-3">
                <button class="btn btn-primary" id="show-modal" @click="showModal = true">Ajouter un article <font-awesome-icon class="text-light" icon="fa-solid fa-circle-plus" /></button>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
            </div>
            <div class="col-4 p-4">
                <ul class="list-group">
                    <li v-for="(item,index) in items_list" :key="index" class="list-group-item">
                        <div class="row align-items-center m-1">
                            <div class="col">
                                <img :src="getImgUrl(item.logo)" style="width: 100px;" class="img-fluid" alt="Shopping item logo">
                            </div>
                            <div class="col">
                                <span class="text-uppercase, fw-bold">{{item.name}}</span>
                            </div>
                            <div class="col-xxl-1 col-xl-2 col-lg-2 col-md-2 col-sm-2">
                                <button class="btn btn-primary" id="show-modal-update" @click="callUpdateModal(item.id, index, item.name, item.logo)"><font-awesome-icon class="text-light" icon="fa-solid fa-pen-to-square" /></button>
                            </div>
                            <div class="col-xxl-1 col-xl-2 col-lg-2 col-md-2 col-sm-2" v-if="item.shoppingSharingItems.length > 0">
                                <div v-for="shoppingSharingItems in item.shoppingSharingItems" v-if="item.shoppingSharingItems.length > 0">
                                    <div v-if="typeof shoppingSharingItems.shoppingSharingUser.user.id !== 'undefined' && shoppingSharingItems.shoppingSharingUser.user.id == this.userId">
                                        <button class="btn btn-danger" id="already-sharing" @click="removeSharingItem(shoppingSharingItems.id)"><font-awesome-icon icon="fa-solid fa-trash-can-arrow-up" /></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-1 col-xl-2 col-lg-2 col-md-2 col-sm-2" v-else>
                                <button class="btn btn-success" id="show-modal-sharing" @click="callSharingModal(item.id)"><font-awesome-icon class="text-light" icon="fa-solid fa-share" /></button>
                            </div>
                            <div class="col-xxl-1 col-xl-2 col-lg-2 col-md-2 col-sm-2">
                                <button class="btn btn-danger" @click="removeItem(item.id)"><font-awesome-icon class="text-light" icon="fa-solid fa-trash" /></button>
                            </div>
                        </div>
                        <div class="row align-items-center">

                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
            </div>
            <div class="col-4 p-4">
                <h3>Articles partagés avec moi</h3>
                <ul class="list-group">
                    <li v-for="(item,index) in sharing_list" :key="index" class="list-group-item m-2">
                        <div class="row align-items-center">
                            <div class="col">
                                <img :src="getImgUrl(item.item.logo)" style="width: 100px;" class="img-fluid" alt="Shopping item logo">
                            </div>
                            <div class="col">
                                <span class="text-uppercase, fw-bold">{{item.item.name}}</span>
                            </div>
                            <div class="col">
                                <span class="text-uppercase, fw-bold"><font-awesome-icon icon="fa-solid fa-user" />{{item.shoppingSharingUser.user.username}}</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <Teleport to="body" v-if="show">
        <!-- use the modal component, pass in the prop -->
        <modal :show="showModal" @submit-item="onSubmitItem" @close="showModal = false">
            <template #header>
                <h3>Ajouter un article</h3>
            </template>
        </modal>
        <modal-update :show="showModalUpdate" :indexToUpdate="indexToUpdate" :idToUpdate="idToUpdate" :nameToUpdate="nameToUpdate" :logoToUpdate="logoToUpdate" @update-item="onUpdateItem" @close="showModalUpdate = false">
            <template #header>
                <h3>Mettre à jour un article</h3>
            </template>
        </modal-update>
        <modal-sharing :show="showModalSharing" :idToSharing="idToSharing" :userId="userId" @update-item="getItemsList" @close="showModalSharing = false">
            <template #header>
                <h3><font-awesome-icon class="text-light" icon="fa-solid fa-share" /> Partager cet article</h3>
            </template>
        </modal-sharing>
    </Teleport>
</template>