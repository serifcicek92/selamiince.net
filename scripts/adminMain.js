$(document).ready(function () {
    $('#dialog-form').dialog({
        autoOpen: false,
        title: 'Düzenleme',
        modal: true
    });
    $('#create-user').click(function () {
        $('#dialog-form').dialog('open');
    });
    document.querySelector("#vazgec").addEventListener("click",function(e) {
      e.preventDefault();
      $( "#dialog-form" ).dialog("close");
    });
});

if (document.querySelector("#addform")) 
{
  document.querySelector("#addform").addEventListener("submit",function(event){
      event.preventDefault();
      const form = document.querySelector("#addform");
      const inputsx = document.querySelectorAll("#addform input");
      
      const formData = new FormData(form);
      formData.append('islem',form.dataset.post);                     
      const xhr = new XMLHttpRequest();
      xhr.open("POST","admin/mulkiyetekle");
      xhr.onloadstart = function() {
          //progressbar document.querySelector("#loader").style.display = "flex";
      }
      xhr.onreadystatechange = function() {
          console.log("response da");
      if (this.readyState == 4 && this.status == 200) 
      {
          console.log(this.responseText);
      }
      if (this.status==201) {
          console.log("BAŞARILI");
          
          document.querySelector("#addAlert").style.display = "block";
          setTimeout(function(){document.querySelector("#addAlert").style.display = "none";form.reset();window.location.reload();},3000);

      }
      // console.log(this.responseText);
      console.log(this.readyState);
      console.log(this.status);
      //document.querySelector("#loader").style.display = "none";
      // window.location.reload();
      }
      xhr.send(formData);
  });

}
document.querySelector(".file-upload-default").addEventListener("change",function(event){
    if ($(".file-upload-default")[0].files.length > 10) {
        alert("Aynı anda 10 adet resim yükleyebilirsiniz");
    } else {
        document.querySelector(".imageloader").classList.remove("d-none");
        document.querySelector("#imageaddForm").submit();
    }
    
});
  window.onload = function(e){
      const tblView = document.querySelector(".table-content");
      tblView.firstElementChild.classList.remove("d-none");

  };

if (document.querySelectorAll(".editbuttons")) 
{
    const editButtons = document.querySelectorAll(".editbuttons");
    Array.from(editButtons).forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const editResimLink = link.parentNode.parentNode.querySelector("td:nth-child(2) img").src;
            const editId = link.parentNode.parentNode.querySelector("td:nth-child(1)").innerHTML;
            const editBaslik = link.parentNode.parentNode.querySelector("td:nth-child(3)").innerHTML;
            const editAltBaslik = link.parentNode.parentNode.querySelector("td:nth-child(4)").innerHTML;
            const editdetay = link.parentNode.parentNode.querySelector("td:nth-child(5)").innerHTML;
            const editKategori = link.parentNode.parentNode.querySelector("td:nth-child(6)").dataset.menuref;
            const editKatTipi = link.parentNode.parentNode.querySelector("td:nth-child(7)").dataset.kattipi;
            const editForm = document.querySelector("#editform");
  
            if (link.dataset.editbuttons=="delete" ) 
            {
                if (confirm('kayıdı silmek istiyormusunuz?')) 
                {
                console.log("delete");
  
                      const xhr = new XMLHttpRequest();
                      xhr.open("GET","admin/kategoridetay/"+editId);
                      xhr.onreadystatechange = function() {
                          if (this.readyState == 4 && this.status == 200) 
                          {
                              console.log("BAŞARILI");
                              
                              document.querySelector("#dellAlert").style.display = "block";
                              setTimeout(function(){ document.querySelector("#dellAlert").style.display = "none"; location.reload();},2000);
                          }
                          if (this.status==400) {
                              
                  
                          }
                          console.log(this.responseText);
                      }
                      xhr.send();
                }
            }
            if (link.dataset.editbuttons=="edit") 
            {
                var image = new Image();
                
                editForm.querySelector("#detayid").value = editId;
                editForm.querySelector("#menuref").value = editKategori;
                editForm.querySelector("#kategoritip").value = editKatTipi;
                editForm.querySelector("#baslik").value = editBaslik;
                editForm.querySelector("#detayaltbaslik").value = editAltBaslik;
                editForm.querySelector("#detayaciklama").value = editdetay;
                editForm.querySelector("#editImg").src = editResimLink;
                // console.log(editForm.querySelector("#img").files[0]);
                $('#dialog-form').dialog('open');
                const imgInput =  editForm.querySelector(".file-upload-default");
                imgInput.addEventListener("change",function(event) {
                   editForm.querySelector("#editImg").src = editForm.querySelector(".file-upload-default").files[0];
                  if (imgInput.files && imgInput.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                      editForm.querySelector("#editImg").src = e.target.result;
                    }
                    reader.readAsDataURL(imgInput.files[0]);
                  }
                  
                  console.log(editForm.querySelector("#editImg").src);
                  
                });
            }
            if (link.dataset.editbuttons=="add" ) 
            {
                console.log("add");
            }
        });
    });
}

  if (document.querySelectorAll(".kategorisec")) {
      var kategorisec = document.querySelectorAll(".kategorisec");
      Array.from(kategorisec).forEach(kategori => {
        kategori.addEventListener('click', function(event) {
            event.preventDefault();
            var kategorid = kategori.dataset.kategori;
            var kategoridetayTablolari = document.querySelectorAll("#kategoridetaytablo");
            Array.from(kategoridetayTablolari).forEach(tablo=>{
                if(tablo.dataset.kategori==kategorid){tablo.classList.remove("d-none");}
                else{if (tablo.className!="d-none") {tablo.classList.add("d-none");}}
            });
        });
    });
  }

if (document.querySelectorAll(".statusx")) 
{
    var statusx = document.querySelectorAll(".statusx");
    Array.from(statusx).forEach(statu=>{
        statu.addEventListener('click',function(e) {
           e.preventDefault();
           console.log("id"+statu.parentNode.parentNode.querySelector('td:nth-child(1)').innerHTML);
           const formData = new FormData();
           formData.append('id',statu.parentNode.parentNode.querySelector('td:nth-child(1)').innerHTML);
           formData.append('status',statu.dataset.statusx);
           console.log(statu.dataset.statusx);
           const xhr = new XMLHttpRequest();
           xhr.open("POST","user/guncelle");
           xhr.onloadstart = function() 
           {
            //progressbar document.querySelector("#loader").style.display = "flex";
           }
            xhr.onreadystatechange = function() {
            if (this.readyState == 4 && (this.status == 200 ||this.status == 201)) 
            {
                console.log("Dönen \n"+this.responseText+"-----");
                console.log("status : "+this.status);
                document.querySelector("#addAlert").style.display = "block";
                setTimeout(function(){
                    document.querySelector("#addAlert").style.display = "none";
                    location.reload();
                },3000);
                console.log("güncellendi");
            }
            else if(this.status == 400)
            {
                document.querySelector("#addError").style.display = "block";
                setTimeout(function(){document.querySelector("#addError").style.display = "none";},3000);
            }

            console.log(this.readyState);
            console.log(this.status);

            }
            xhr.send(formData);
        });
    });
}


