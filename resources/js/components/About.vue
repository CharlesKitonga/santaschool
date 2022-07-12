<template>
    <div class="container">
        <div class="row mt-5"  >
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Aboutpage Details</h3>

                <div class="card-tools">
                    <button class="btn btn-success" @click="newModal">Add Info <i class="fas fa-plus-square fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                        <th>Heading</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="about in abouts.data" :key="about.id">
                      <td>{{about.heading}}</td>
                      <td v-html="about.description"></td>
                      <td>
                        <img class="img-fluid mb-3" :src="'./images/homes/'+about.photo" style="width:70px;" alt=" Avatar">
                      </td>
                      <td>
                          <a href="#" @click="editModal(about)">
                              <i class="fa fa-edit text-blue"></i>
                          </a>
                          /
                           <a href="#" @click="deleteAbout(about.id)">
                              <i class="fa fa-trash text-red"></i>
                          </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <div class="card-footer">

            </div>
          </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="aboutModal" tabindex="-1" role="dialog" aria-labelledby="aboutModalMLabel" aria-hidden="true">
            <div class="modal-dialog  modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="aboutModalLabel">Add Home Details</h5>
                        <h5 class="modal-title" v-show="editmode" id="aboutModalLabel">Update Home Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent = "editmode ? updateAbout() :createAbout()">
                    <div class="modal-body">
                        <div class="form-group">
                            <input v-model="form.heading" type="text" name="heading" placeholder="About the school Information"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('heading') }">
                            <has-error :form="form" field="heading"></has-error>
                        </div>
                        <div class="form-group">
                            <vue-editor v-model="form.description"></vue-editor>
                        </div>
                          <div class="form-group row">
                            <label for="photo" class="col-sm-4 col-form-label">Homepage Photo</label>
                            <div class="col-sm-6">
                                <input type="file" v-show="!editmode" accept="image/*" @change="uploadphoto" class="form-input"/>
                                <input type="file" v-show="editmode" accept="image/*" @change="updateAboutPic"  class="form-input"/>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                        <button v-show="!editmode" type="submit" class="btn btn-primary">Save Details</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// Basic Use - Covers most scenarios
import { VueEditor } from "vue2-editor";
    export default {
        data(){
            return{
                //check if it's an edit function and switch to the modal
                editmode: false,
                //fetch products from db using axios
                abouts:{},
                // create a new form instance
                form: new Form({
                    id: '',
                    heading: '',
                    description: '',
                    body: '',
                    photo: ''
                })
            }
        },
        methods: {
          // method to GET results from a Laravel endpoint
            getResults(page = 1) {
                axios.get('api/user?page=' + page)
                    .then(response => {
                        this.abouts = response.data;
                    });
            },
            updateAboutPic(e){
                //console.log('uploading');
                //grab the file we are uploading
                let file = e.target.files[0];
                console.log(file);
                //convert the file to base63
                let reader = new FileReader();
                if (file['size'] < 2111775) {
                    reader.onloadend = (file) =>{
                        //console.log('RESULT', reader.result);
                        this.form.photo = reader.result;
                    }
                    reader.readAsDataURL(file);
                }else{
                    Swal.fire("Oops...", "You are uploading a large file!", "error");

                }

            },
            updateAbout(){
                this.$Progress.start();
                this.form.put('api/abouts/'+this.form.id)
                .then(()=>{
                    //if successfull
                    Swal.fire(
                        'Updated Successfully!',
                        'Your Information has been Updated.',
                        'success'
                    )
                    this.$Progress.finish();
                    $('#aboutModal').modal('hide')
                    Fire.$emit('AfterCreate');
                })
                .catch(()=>{
                    //else throw an error
                    this.$Progress.fail();
                    swal("Failed!", "There was Something Wrong.", "Warning");
                });
            },
            editModal(product){
                this.editmode = true;
                $('#aboutModal').modal('show');
                this.form.fill(product);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#aboutModal').modal('show')
            },
            deleteAbout(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                        //send request to the server
                        if (result.value) {
                            this.form.delete('api/abouts/'+id).then(()=>{
                                    Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    'success'
                                    )
                                Fire.$emit('AfterCreate');
                            }).catch(()=>{
                                swal("Failed!", "There was Something Wrong.", "Warning");
                            });
                        }
                    })
            },
            uploadphoto(e){
                //console.log('uploading');
                //grab the file we are uploading
                let file = e.target.files[0];
                console.log(file);
                //convert the file to base63
                let reader = new FileReader();
                if (file['size'] < 2111775) {
                    reader.onloadend = (file) =>{
                        //console.log('RESULT', reader.result);
                        this.form.photo = reader.result;
                    }
                    reader.readAsDataURL(file);
                }else{
                    Swal.fire("Oops...", "You are uploading a large file!", "error");

                }

            },
            loadAboutDetails(){
                axios.get("api/abouts").then(({ data }) => (this.abouts = data))
            },
            createAbout(){
                // [Product.vue specific] When Product.vue is first loaded start the progress bar
                this.$Progress.start();
                this.form.post('api/abouts')
                .then(()=>{
                    Fire.$emit('AfterCreate');
                    //  [Product.vue specific] When Product.vue is finish loading finish the progress bar
                    $('#aboutModal').modal('hide')
                    Toast.fire({
                        icon: 'success',
                        title: 'Aboutpage Details Added Successfully'
                    })
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail();

                })
            }
        },
        created() {
            //listen to a search event and send an http request
            Fire.$on('searching', ()=>{
                //fetch data from the root instance of the application <app.js>
                let query = this.$parent.search;
                //use axios to query the db
                axios.get('api/findUser?q='+ query)
                .then((data)=>{
                    this.abouts = data.data
                })
                .catch(()=>{

                })

            });
            this.loadAboutDetails();
            /* this method sends http request every three seconds */
            //setInterval(() => this.loadAboutDetails(), 3000);
            Fire.$on('AfterCreate', () =>{
                this.loadAboutDetails();
            });
        }
    }
</script>

