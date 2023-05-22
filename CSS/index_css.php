<style>
    body { 
        background-image: url('./Image/BG/bground.png');
        background-repeat: no-repeat;
        background-size: 100% 100%;
        background-attachment: fixed;
    }

    .solid {
        transition: .4s;
    }

    .solid a img{
        width: 100%;
    }
    
    .solid:hover{
        transform: translateY(-6px);
    }

    .title{
        backdrop-filter: blur(3px); 
        background-color: rgba(0, 0, 0, 0.3);
    }

    .title-text{
        background: linear-gradient(50deg, #00dbde, #fc00ff, #00dbde, #fc00ff);
        background-size: 400%;
        -webkit-text-fill-color:transparent;
        -webkit-background-clip: text;
        animation: animate 15s linear infinite;
    }

    @keyframes animate{
        0%{
            background-position: 0%;
        }
        100%{
            background-position: 400%;
        }
    }

    .row{
        align-items: center;
        justify-content: center;
    }

    .card {
        position: relative;
    }

    .detail_pro{
        position: absolute;
        top: 14.8rem;
        background-color: rgb(13, 13, 13, 0.6);
        height: 3rem;
        opacity: 0;
        transition: .6s;
    }

    .detail_pro i{
        font-size: 0.9rem;
        opacity: 0.8;
        margin: 0 0.4rem;
    }

    .detail_pro a{
        line-height: 1rem;
    }

    .card:hover .detail_pro{
        opacity: 1;
        transform: translateY(-2rem);
    }
</style>
