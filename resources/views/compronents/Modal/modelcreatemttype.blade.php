<div class='container-sm mt-1 mb-1 d-flex justify-content-end align-items-end'>   
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#MeterType">
                    Create 
                   </button>
               <div class="modal fade" id="MeterType" tabindex="-1" aria-labelledby="exampleModalLabel"
                   aria-hidden="true">
                   <div class="modal-dialog">
                       <div class="modal-content">
                           <div class="modal-header">
                               <h1 class="modal-title fs-5" id="exampleModalLabel">Create Meter Type</h1>
                               <button type="button" class="btn-close" data-bs-dismiss="modal"
                                   aria-label="Close"></button>
                           </div>
                           <form action="{{url('/addmeter')}}" method="POST" enctype="multipart/form-data">
                               @csrf
                               <div class="modal-body">

                                   <div class="row">
                                       <div class="col-md-12">
                                           <div class="form-group my-2">
                                               <strong>Name:</strong>
                                               <input type="text" name="name" class="form-control" placeholder="Name">
                                           </div>
                                       </div>
                                       <div class="col-md-12">
                                        <div class="form-group my-2">
                                            <strong>Price/Unit:</strong>
                                            <input type="number" name="price_unit" class="form-control"
                                                placeholder="Price/Unit">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                           </form>
                       </div>
                    </div>
                </div>
            </div>
