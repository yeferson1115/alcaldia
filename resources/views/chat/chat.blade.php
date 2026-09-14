@extends('layouts.app')

@section('title', 'Editar Acuerdo de Pago')
@section('page_title', 'Editar Acuerdo de Pago')

@section('content')

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="app-chat card overflow-hidden">
                <div class="row g-0">
                  <!-- Sidebar Left -->
                  <div class="col app-chat-sidebar-left app-sidebar overflow-hidden" id="app-chat-sidebar-left">
                    <div
                      class="chat-sidebar-left-user sidebar-header d-flex flex-column justify-content-center align-items-center flex-wrap px-6 pt-12">
                      <div class="avatar avatar-xl avatar-online chat-sidebar-avatar">
                        <img src="{{ asset('assets/img/favicon/favicon.ico') }}assets/img/avatars/1.png" alt="Avatar" class="rounded-circle" />
                      </div>
                      <h5 class="mt-4 mb-0">John Doe</h5>
                      <span>Admin</span>
                    </div>
                  </div>
                  <!-- /Sidebar Left-->

                  <!-- Chat & Contacts -->
                  <div
                    class="col app-chat-contacts app-sidebar flex-grow-0 overflow-hidden border-end"
                    id="app-chat-contacts">
                    <div class="sidebar-header h-px-75 px-5 border-bottom d-flex align-items-center">
                      <div class="d-flex align-items-center me-6 me-lg-0">
                        <div
                          class="flex-shrink-0 avatar avatar-online me-4"
                          data-bs-toggle="sidebar"
                          data-overlay="app-overlay-ex"
                          data-target="#app-chat-sidebar-left">
                          <img
                            class="user-avatar rounded-circle cursor-pointer"
                            src="{{ asset('assets/img/avatars/1.png') }}"
                            alt="Avatar" />
                        </div>
                        
                      </div>
                      <i
                        class="ti ti-x ti-lg cursor-pointer position-absolute top-50 end-0 translate-middle d-lg-none d-block"
                        data-overlay
                        data-bs-toggle="sidebar"
                        data-target="#app-chat-contacts"></i>
                    </div>
                    <div class="sidebar-body">
                      <!-- Chats -->
                      <ul class="list-unstyled chat-contact-list py-2 mb-0" id="chat-list">
                        
                      
                      </ul>
                     
                    </div>
                  </div>
                  <!-- /Chat contacts -->

                  <!-- Chat History -->
                  <div class="col app-chat-history">
                    <div class="chat-history-wrapper">
                      <div class="chat-history-header border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                          <div class="d-flex overflow-hidden align-items-center">
                            <i
                              class="ti ti-menu-2 ti-lg cursor-pointer d-lg-none d-block me-4"
                              data-bs-toggle="sidebar"
                              data-overlay
                              data-target="#app-chat-contacts"></i>
                            <div class="flex-shrink-0 avatar avatar-online">
                                <div class="avatar d-block flex-shrink-0">
                                <span class="avatar-initial rounded-circle bg-label-primary"></span>
                                </div>
                            </div>
                            <div class="chat-contact-info flex-grow-1 ms-4" >
                              <h6 class="m-0 fw-normal" id="nameuser"></h6>                              
                            </div>
                          </div>
                          <div class="d-flex align-items-center">
                           
                            
                            
                            
                          </div>
                        </div>
                      </div>
                      <div class="chat-history-body">
                        <ul class="list-unstyled chat-history" id="messages">

                         
                        </ul>
                      </div>
                      <!-- Chat message form -->
                      <div class="chat-history-footer shadow-xs">
                        <form class="form-send-message d-flex justify-content-between align-items-center">
                          <input
                            class="form-control message-input border-0 me-4 shadow-none"
                            placeholder="Mensaje...." id="message" />
                          <div class="message-actions d-flex align-items-center" >
                            
                            
                            <button class="btn btn-primary d-flex send-msg-btn" onclick="sendMessage()">
                              <span class="align-middle d-md-inline-block d-none">Enviar</span>
                              <i class="ti ti-send ti-16px ms-md-2 ms-0"></i>
                            </button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <!-- /Chat History -->

                 

                  <div class="app-overlay"></div>
                </div>
              </div>
            </div>
            <div class="content-backdrop fade"></div>
            <div class="layout-overlay layout-menu-toggle"></div>
            <!-- Drag Target Area To SlideIn Menu On Small Screens -->
            <div class="drag-target"></div>

    <!-- build:js assets/vendor/js/core.js -->
@endsection

@push('scripts')
<script>
        let chatId;

        // Configurar el token CSRF para las solicitudes AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Iniciar chat
        $(document).ready(function() {
            $.post('/chat/start', function(data) {
                chatId = data.chat_id;
                loadMessages();
            });
        });

        // Cargar mensajes periódicamente
        function loadMessages() {
            $.get(`/chat/${chatId}/messages`, function(messages) {
                $('#messages').html('');
                messages.forEach(msg => {
                    if(msg.user_id!=null){
                        $('#messages').append(` <li class="chat-message">
                            <div class="d-flex overflow-hidden">
                              <div class="chat-message-wrapper flex-grow-1">
                                <div class="chat-message-text">
                                  <b>Agente:</b>
                                  <p class="mb-0">${msg.message}</p>
                                </div>
                                <div class="text-end text-muted mt-1">
                                  <i class="ti ti-checks ti-16px text-success me-1"></i>
                                  <small>${msg.created_at}</small>
                                </div>
                              </div>
                              <div class="user-avatar flex-shrink-0 ms-4">
                                <div class="avatar avatar-sm">
                                  
                                </div>
                              </div>
                            </div>
                          </li>`);
                    }
                    if(msg.guest_id!=null){
                        $('#messages').append(`<li class="chat-message chat-message-right">
                            <div class="d-flex overflow-hidden">
                              <div class="chat-message-wrapper flex-grow-1">
                                <div class="chat-message-text">
                                  <b>Cliente:</b>
                                  <p class="mb-0">${msg.message}</p>
                                </div>
                                <div class="text-end text-muted mt-1">
                                  <i class="ti ti-checks ti-16px text-success me-1"></i>
                                  <small>${msg.created_at}</small>
                                </div>
                              </div>
                              <div class="user-avatar flex-shrink-0 ms-4">
                                <div class="avatar avatar-sm">
                                  
                                </div>
                              </div>
                            </div>
                          </li>`);
                    }
                    
                });
            });
        }

        // Enviar mensaje
        function sendMessage() {
            let message = $('#message').val();
            $.post('/chat/send', { chat_id: chatId, message: message }, function() {
                $('#message').val('');
                loadMessages();
            });
        }

        // Actualizar cada 3 segundos
        setInterval(loadMessages, 3000);
    </script>
@endpush



