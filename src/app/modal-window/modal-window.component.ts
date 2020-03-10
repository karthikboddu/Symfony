import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-modal-window',
  templateUrl: './modal-window.component.html',
  styleUrls: ['./modal-window.component.scss']
})
export class ModalWindowComponent implements OnInit {

  constructor(private route: ActivatedRoute,private router: Router) { }
  hideCloseText: boolean = false;
  ngOnInit() {
    console.log("modal");
    document.getElementById('popupClose').focus();
 

    let hideCloseText = this.route.snapshot.data["hideCloseText"];
    if(hideCloseText != null && hideCloseText === true) {
      this.hideCloseText = true;
    }
  }

  onActivate(componentReference) {
    debugger
    if (componentReference.closeActiveModal) {
      componentReference.closeActiveModal.subscribe((data) => {
        this.closeModal();
      });
    }
  }

  closeModal() {
    // this.enableBodyScroll();

    this.router.navigate([{ outlets: { modal: null } }]);

  }

  private disableBodyScroll() {
    setTimeout(() => {
      document.body.classList.add('modal-open');  
    }, 0);
  }

  private enableBodyScroll() {
   
  }

}
