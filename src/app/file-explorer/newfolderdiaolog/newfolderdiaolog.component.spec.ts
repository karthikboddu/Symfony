import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { NewfolderdiaologComponent } from './newfolderdiaolog.component';

describe('NewfolderdiaologComponent', () => {
  let component: NewfolderdiaologComponent;
  let fixture: ComponentFixture<NewfolderdiaologComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ NewfolderdiaologComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(NewfolderdiaologComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
