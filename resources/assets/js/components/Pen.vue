<template>
  <div class="col-md-3">
    <div class="card">
      <div class="card-header">Pen {{pen.id}}</div>
      <div class="card-body">
        <p class="card-text">Sheeps: {{pen ? pen.sheeps : '0'}}</p>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["pen"],
  mounted() {
    console.log("Component mounted.");
  }
};
</script>