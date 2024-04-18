<template>
  <layout-div>
    <div class="row justify-content-md-center">
      <div class="col-12">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <div class="container-fluid">
            <a class="navbar-brand" href="#">Dashboard</a>
            <div class="d-flex">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a @click="logoutAction()" class="nav-link " aria-current="page" href="#">Logout</a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
      </div>

      <layout-div>
        <div class="row justify-content-md-center mt-5">
          <div class="col-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title mb-4">Create Order</h5>
                <form @submit.prevent="createOrder">
                  <div class="mb-3">
                    <label for="customer" class="form-label">Customer Name</label>
                    <input type="text" class="form-control" id="customer" v-model="customer" />
                  </div>
                  <div class="mb-3">
                    <label for="detail" class="form-label">Detail</label>
                    <textarea class="form-control" type="text" id="detail" v-model="detail"></textarea>
                  </div>
                  <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <input type="text" class="form-control" id="status" v-model="status" />
                  </div>
                  <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-block">Create Order</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </layout-div>
    </div>
  </layout-div>
</template>

<script>
import axios from 'axios';
import LayoutDiv from '../LayoutDiv.vue';

export default {
  name: 'DashboardPage',
  components: {
    LayoutDiv,
  },
  data() {
    return {
      user: {},
      customer: '',
      detail: '',
      status: '',
    };
  },
  created() {
    this.getUser();
    if (!localStorage.getItem('token')) {
      this.$router.push('/');
    }
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

    logoutAction() {
      this.$router.push('/');
      localStorage.setItem('token', '');
      axios.post('/logout.php', {}, {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}})
          .then((r) => {
            return r;
          })
          .catch((e) => {
            return e;
          });
    },

    createOrder() {
        const payload = {
          user_id: this.$data.user.ID, // Assuming user ID is needed to create an order
          customer: this.customer,
          detail: this.detail, // Convert textarea value to array
          status: this.status,
        };

      axios.post('/create_order.php', payload)
          .then((response) => {
            console.log('Order created successfully:', response.data);
            this.$router.push('/dashboard');
          })
          .catch((error) => {
            console.error('Error creating order:', error);
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
