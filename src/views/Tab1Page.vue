<template>
  <ion-page>
    <ion-header>
      <ion-toolbar>
        <ion-title style="text-align: center;"><b>Daftar Pesan</b></ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-content class="ion-padding">
      <ion-card style="box-shadow: 10px;">
        <ion-card-header>
          <ion-card-title><b>Tambahkan Pesan</b></ion-card-title>
        </ion-card-header>
        <ion-card-content>
  <ion-list>
    <ion-item>
      <ion-input v-model="newTitle" label-placement="floating">
        <div slot="label"><b>Judul Pesan</b></div>
      </ion-input>
    </ion-item>
  </ion-list>
    <ion-list>
    <ion-item>
      <ion-input v-model="newBody" label-placement="floating">
        <div slot="label"><b>Isi Pesan</b></div>
      </ion-input>
    </ion-item>
  </ion-list>
          <ion-button expand="block" @click="createPost" color="dark">Kirim</ion-button>
        </ion-card-content>
      </ion-card>
      <ion-card v-for="post in posts" :key="post.id">
        <ion-card-header>
          <ion-card-title>{{ post.title }}</ion-card-title>
        </ion-card-header>
        <ion-card-content>
          {{ post.body }}
        </ion-card-content>
      </ion-card>
    </ion-content>
  </ion-page>
</template>

<script setup lang="ts">
import { ref, onMounted } from "vue";
import axios from "axios";
import {
  IonPage,
  IonHeader,
  IonToolbar,
  IonTitle,
  IonContent,
  IonCard,
  IonCardHeader,
  IonCardTitle,
  IonCardContent,
  IonInput,
  IonButton,
} from "@ionic/vue";


const posts = ref<any[]>([]);


const newTitle = ref("");
const newBody = ref("");


onMounted(async () => {
  const res = await axios.get("https://jsonplaceholder.typicode.com/posts");
  posts.value = res.data;
});


async function createPost() {
  const res = await axios.post("https://jsonplaceholder.typicode.com/posts", {
    title: newTitle.value,
    body: newBody.value,
    userId: 1,
  });


  const newPost = {
    id: Date.now(),
    title: newTitle.value,
    body: newBody.value,
  };


  posts.value.unshift(newPost);


  newTitle.value = "";
  newBody.value = "";

  console.log("Respon dari API:", res.data); 
}
</script>