import { Component, OnInit } from '@angular/core';
import { MatDialogRef } from '@angular/material';

@Component({
  selector: 'app-newfolderdiaolog',
  templateUrl: './newfolderdiaolog.component.html',
  styleUrls: ['./newfolderdiaolog.component.scss']
})
export class NewfolderdiaologComponent implements OnInit {

  constructor(public dialogRef: MatDialogRef<NewfolderdiaologComponent>) {}

  folderName: string;

  ngOnInit() {}

}
