<style>
    .imgc {
        position: relative;
        width: 100%;
        height: 170px;
    }

    .imgc img {
        width: 100%;
        height: 168px;


    }

    .imgc .btn {
        position: absolute;
        top: 8%;
        left: 98%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        background-color: red;
        color: white;
        font-size: 10px;
        /* padding: 12px 24px; */
        /* border: none; */
        border-radius: 50%;
        cursor: pointer;
        /* border-radius: 5px; */
        text-align: center;
    }

    .imgc .btn:hover {

        background-color: red;
        color: #fff;
        font-size: 16px;
    }



    .imgc:hover {
        cursor: pointer;
        transform: translate(-1%, -1%);
        border: 1px solid red;
    }
</style>

<div class="imgc">
    <button type="button" class="btn" id="{{ $btnid }}"><i class="bi bi-trash"></i></button>
    <img id="{{ $id }}" src="{{ $src }}" alt="" class="img-fluid">
    <input name="{{ $name }}" id="{{ $name }}" type="file" hidden>
</div>
