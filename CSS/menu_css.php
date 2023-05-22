<style>
  nav{
      background-color: rgba(0, 0, 0, 0.8);
  }

  nav a:hover{
    text-shadow: 0.1px 0.1px 0.1rem white;
    font-size: 1.1rem;
  }

  nav a{
      background: linear-gradient(50deg, #00dbde, #fc00ff, #00dbde, #fc00ff);
      -webkit-text-fill-color: transparent;
      -webkit-background-clip: text;
      background-clip: text;
  }

  .dropdown-menu{
    background-color: rgba(0, 0, 0, 0.8);
    border: none;
  }

  #search{
      outline: none;
      padding-left: 1rem;
      border: none;
      border-bottom-left-radius: 5rem;
      border-top-left-radius: 5rem;
  }

  .btn_search{
      border-top-right-radius: 5rem;
      border-bottom-right-radius: 5rem;
      color: black;
      background-color: white;
      border: none;
  }

  .btn_search:hover{
    background-color: black;
    color: white;
  }

  #log_reg{
    margin-right: 10%; 
    float: right; 
    width: 15%; 
    position: relative;
  }

  #log_reg ul.dropdown-menu{
    min-width: 0%;
  }

  #shopCart{
    position: absolute; 
    right: -1rem; 
    top: -1rem; 
    margin-left: 50%;
  }

  .amount{
    position: absolute; 
    top: -0.5rem; 
    right: -0.6rem;
  }

  .amount div{
    position: relative;
    background-color: red; 
    color: white; 
    border-radius: 50%; 
    width: 16px; 
    height: 16px;
    box-shadow: 0 0 0.1rem 0.05rem white;
  }

  .amount div small{
    position: absolute;
    top: -0.17rem;
  }
</style>