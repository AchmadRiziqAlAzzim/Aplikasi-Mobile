<template>
  <ion-page class="posisi">
      <ion-card class="card">
         <div class="posisi2">
          <img alt="Silhouette of mountains" src="/public/murid.png" class="img" />
         </div>
        <h1 id="custom-input" style="text-align: center;">Form Login</h1>
      <ion-card-content>
        <ion-input label="Username" v-model="email" id="custom-input" :counter="true" maxlength="20"></ion-input>
        <ion-input label="Password" v-model="password" id="custom-input" :counter="true" maxlength="20">
        <ion-input-password-toggle slot="end"></ion-input-password-toggle></ion-input>
      </ion-card-content>
      <ion-button expand="block" @click="eksekusi" color="dark">Login</ion-button>
    </ion-card>
    <ion-toast
      :is-open="showToast"
      :message="toastMessage"
      :color="toastColor"
      position="top"
      :duration="2000"
      @didDismiss="showToast = false"
    ></ion-toast>
  </ion-page>
</template>

<script setup>
import axios from 'axios'
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { IonPage, IonInput, IonCard, IonCardContent, IonInputPasswordToggle, IonToast } from '@ionic/vue';

  const showToast = ref(false)
  const toastMessage = ref('')
  const toastColor = ref('success')

  const router = useRouter()
  const email = ref('')
  const password = ref('')

  const eksekusi = async () => {
  try {
    const res = await axios.post(
      'http://localhost/aplikasi/server/login.php',

      {
        email: email.value,
        password: password.value
      },
      {
        headers: { "X-API_KUNCI": "RiziqSigma" }
      }
    );

    toastMessage.value = res.data.pesan
    toastColor.value = res.data.status === "Berhasil" ? 'success' : 'danger'
    showToast.value = true

    if (res.data.status === "Berhasil") {
        await new Promise(resolve => setTimeout(resolve, 800));
        router.push("/UserTable");
    }

  } catch (err) {
    console.error(err)
    toastMessage.value = 'Gagal koneksi ke server'
    toastColor.value = 'danger'
    showToast.value = true
  }
}



</script>

<style scoped>

.img {
  width: 16dvh;
}

.posisi {
  display: flex;
  align-items: center !important;
  justify-content: center;
  height: 100dvh !important;
}

.posisi2 {
  display: flex; 
  justify-content: center;
}

#custom-input {
  font-weight: bold;
  color: #000000;
}

.card {
  padding: 30px;
  border-radius: 20px;
  width: 90%;
  max-width: 60dvh;
  box-shadow: none;
}
</style>