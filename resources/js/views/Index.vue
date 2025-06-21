<template>
    <div class="container">
        <h1>Users</h1>
      <div v-if="users" class="users">
          <article v-for="user in users">
              <p>{{user.id}}</p>
              <p>{{user.email}}</p>
              <p>{{user.name}}</p>
              <router-link :to="{name: 'ShowUser', params:{id:user.id}}">Подробнее</router-link>
          </article>
      </div>
    </div>
</template>

<script setup>
import {ref} from "vue";

import axios from "axios";

const users = ref([]);

const getUsers  = () => {
    axios.get('/api/users/')
        .then(res => {
            console.log(res.data)
            users.value = res.data.data
        })
}

getUsers()

</script>

<style>

.container {
    margin: 0 20px;

    h1 {
        margin-bottom: 30px;
        font-weight: bold;
    }
}
article {
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1px solid #ccc;
}
</style>
