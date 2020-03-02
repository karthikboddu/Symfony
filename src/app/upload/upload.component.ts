import { Component, OnInit , Input, Output, EventEmitter} from '@angular/core';
import { MatDialog } from '@angular/material';
import { UploadService } from '../services/upload.service';
import { UploadDialogComponent } from './upload-dialog/upload-dialog.component';
import { FileElement } from '../models/file-explorer';
import { FileService } from '../services/file.service';
import { first } from 'rxjs/operators';

@Component({
  selector: 'app-upload',
  templateUrl: './upload.component.html',
  styleUrls: ['./upload.component.scss']
})
export class UploadComponent implements OnInit {

  constructor(public dialog: MatDialog, public uploadService: UploadService,public fileService:FileService) { }

  currentRoot: FileElement;
  userfiledata : any;
  ngOnInit() {
  }

  // async ngOnDestroy() {
  //   if (this.userfiledata) {
  //       this.userfiledata.unsubscribe();
  //   }

    
  // }
  newfileElement: FileElement;
  addFiles(folder: { name: string }) {
    debugger
   console.log("hhSD",folder.name);
   this.newfileElement = this.fileService.add({ isfolder: false, name: folder.name, parent: this.currentRoot ? this.currentRoot.fid : 'root' ,id:''});
   this.fileService.addFilesAndFolders(this.newfileElement.fid,folder.name,'false',this.currentRoot ? this.currentRoot.fid : 'root')
   .pipe(first())
   .subscribe(data=>{
       console.log("addData",data);
     },
     error =>{
       console.log("errors", error);
     });



   // this.updateFileElementQuery();
 }

}
