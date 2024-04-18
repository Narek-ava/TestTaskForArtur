<template>
  <layout-div>
    <!-- Navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Dashboard</a>
        <div class="d-flex">
          <ul class="navbar-nav">
            <!-- Logout button -->
            <li class="nav-item">
              <button @click="logout" class="btn btn-link nav-link">Logout</button>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Dashboard content -->
    <div class="row justify-content-md-center mt-5">
      <div class="col-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-4">Update Order</h5>
            <!-- Order update form -->
            <form @submit.prevent="updateOrder">
              <div class="mb-3">
                <label for="detail" class="form-label">Detail</label>
                <textarea class="form-control" id="detail" v-model="order.detail" required></textarea>
              </div>
              <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <input type="text" class="form-control" id="status" v-model="order.status" required />
              </div>
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-block">Update Order</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </layout-div>
</template>

<script>
import axios from 'axios';
import LayoutDiv from '../LayoutDiv.vue';

export default {
  name: 'UpdateOrder',
  components: {
    LayoutDiv,
  },
  data() {
    return {
      user: {},
      order: {
        customer: '',
        detail: '',
        status: '',
      },
    };
  },
  created() {
    this.getUser();
    const orderId = this.$route.params.orderId;
    this.getOrder(orderId);
  },
  methods: {
    getUser() {
      axios.get('/user.php/' + localStorage.getItem('token'))
          .then((response) => {
            this.user = response.data;
          })
          .catch((error) => {
            console.error('Error fetching user:', error);
          });
    },

    logout() {
      localStorage.removeItem('token');
      this.$router.push('/');
      axios.post('/logout.php', {}, { headers: { Authorization: 'Bearer ' + localStorage.getItem('token') } })
          .then((response) => {
            // Handle logout response if needed
          })
          .catch((error) => {
            console.error('Error logging out:', error);
          });
    },

    getOrder(orderId) {
      axios.get(`/get_order.php?id=${orderId}`)
          .then((response) => {
            // Handle successful response
            this.order = response.data;
          })
          .catch((error) => {
            // Handle error
            console.error('Error fetching order:', error);
          });
    },

    updateOrder() {
      axios.post('/update_order.php', this.order)
          .then((response) => {
            console.log('Order updated successfully:', response.data);
            this.$router.push('/dashboard');
          })
          .catch((error) => {
            console.error('Error updating order:', error);
          });
    },
  },
};
</script>

<style>
.styled-table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin: 1em 0;
}

.styled-table th {
  background-color: #f2f2f2;
  color: #333;
  font-weight: bold;
  padding: 10px;
  text-align: left;
}

.styled-table td {
  border-bottom: 1px solid #ddd;
  padding: 10px;
}

.styled-table tr:hover {
  background-color: #f5f5f5;
}
</style>
