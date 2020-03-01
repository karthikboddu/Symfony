import { Component, OnInit , Input, Output, EventEmitter} from '@angular/core';
import { MatDialog } from '@angular/material';
import { UploadService } from '../services/upload.service';
import { UploadDialogComponent } from './upload-dialog/upload-dialog.component';

@Component({
  selector: 'app-upload',
  templateUrl: './upload.component.html',
  styleUrls: ['./upload.component.scss']
})
export class UploadComponent implements OnInit {

  constructor(public dialog: MatDialog, public uploadService: UploadService) { }


  userfiledata : any;
  ngOnInit() {
  }

  // async ngOnDestroy() {
  //   if (this.userfiledata) {
  //       this.userfiledata.unsubscribe();
  //   }

    
  // }

  addFiles(folder: string) {
    debugger
   console.log("hhSD",folder);
   //this.newfileElement = this.fileService.add({ isfolder: true, name: folder.name, parent: this.currentRoot ? this.currentRoot.fid : 'root' });
   // this.fileService.addFilesAndFolders(this.newfileElement.fid,folder.name,'true',this.currentRoot ? this.currentRoot.fid : 'root')
   // .pipe(first())
   // .subscribe(data=>{
   //     console.log("addData",data);
   //   },
   //   error =>{
   //     console.log("errors", error);
   //   });



   // this.updateFileElementQuery();
 }

}
