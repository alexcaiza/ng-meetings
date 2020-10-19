import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DocentesMainComponent } from './docentes-main.component';

describe('DocentesMainComponent', () => {
  let component: DocentesMainComponent;
  let fixture: ComponentFixture<DocentesMainComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ DocentesMainComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(DocentesMainComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
