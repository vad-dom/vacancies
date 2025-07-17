<template>
  <div class="wrapper">
    <router-view/>
  </div>
</template>

<script>
export default {

}
</script>

<style scoped>

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: Arial, sans-serif;
}

.wrapper {
  padding: 15px 20%;
}

@media (max-width: 1200px) {
  .wrapper {
    padding: 15px 15%;
  }
}

@media (max-width: 800px) {
  .wrapper {
    padding: 15px 5%;
  }
}

@media (max-width: 640px) {
  .wrapper {
    padding: 5px 5px;
  }
}

</style>