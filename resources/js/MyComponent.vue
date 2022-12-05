<script setup>
import { onMounted, ref } from "vue";
import VueCropper from "vue-cropperjs";
import "cropperjs/dist/cropper.css";
import axios from "axios";
let response = ref("");
let cropper = ref(null);
let clickUpload = ref(false);
let file = ref(null);
let fileUpload = ref(null);
let isLoading = ref(false);
const props = defineProps({
    endpoint: String,
});
function getRecords() {
    isLoading.value = true;
    axios.get(`${props.endpoint}`).then((res) => {
        response.value = res.data.photo_url;
        isLoading.value = false;
        //console.log(res.data);
    });
}
function setImage(e) {
    const file = e.target.files[0];
    fileUpload.value = file;
    isLoading.value = true;
    if (file.type.indexOf("image/") === -1) {
        alert("Please select an image file");
        return;
    }
    if (typeof FileReader === "function") {
        clickUpload.value = true;
        const reader = new FileReader();
        reader.onload = (event) => {
            response.value = event.target.result;
            // rebuild cropperjs with the updated source

            isLoading.value = false;
            cropper.value.replace(event.target.result);
        };
        reader.readAsDataURL(file);
    } else {
        alert("Sorry, FileReader API not supported");
    }
}
function cancelClickUpload() {
    clickUpload.value = false;
    getRecords();
}
function imageUpload(e) {
    isLoading.value = true;
    let getCrop = cropper.value.getData();
    console.log(getCrop);
    let formData = new FormData();
    formData.append("photo_url", fileUpload.value);
    formData.append("width", getCrop.width);
    formData.append("height", getCrop.height);
    formData.append("x", getCrop.x);
    formData.append("y", getCrop.y);
    console.log(formData);
    axios
        .post(`${props.endpoint}/upload`, formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
        .then(function () {
            console.log("SUCCESS!!");
            getRecords();
            isLoading.value = false;
            clickUpload.value = false;
        })
        .catch(function () {
            console.log("FAILURE!!");
            isLoading.value = false;
        });
}
onMounted(() => {
    getRecords();
});
</script>

<template>
    <div class="d-flex flex-column">
        <div style="margin: 0 auto" v-if="isLoading">Loading ...</div>
        <div v-else>
            <template v-if="clickUpload">
                <vue-cropper ref="cropper" :src="response" />
            </template>
            <template v-else>
                <img
                    :src="response"
                    class="img-fluid border-secondary border"
                    alt="photo"
                />
            </template>
            <div class="mt-2">
                <form @submit.prevent="imageUpload">
                    <template v-if="clickUpload">
                        <button type="submit" class="btn btn-primary btn-block">
                            Save
                        </button>
                        <button
                            type="button"
                            @click="cancelClickUpload"
                            class="btn btn-danger btn-block"
                        >
                            Cancel
                        </button>
                    </template>

                    <template v-else>
                        <input
                            type="file"
                            ref="file"
                            accept="image/*"
                            @change="setImage"
                        />
                    </template>
                </form>
            </div>
        </div>
    </div>
</template>
