import { Component, signal } from '@angular/core';
import { GreetingComponent } from '../components/greeting/greeting.component';
import { HeaderComponent } from "../components/header/header.component";
import { CounterComponent } from '../components/counter/counter.component';

@Component({
  selector: 'app-home',
  imports: [GreetingComponent, HeaderComponent, CounterComponent],
  templateUrl: './home.component.html',
  styleUrl: './home.component.scss'
})
export class HomeComponent {
  homeMessage = signal("home component pass message world");
  // keyUpHandler() {
  //   console.log('User typed something');
  // }

  keyUpHandler(event: KeyboardEvent) {
    console.log(`User press ${event.key}` );
  }
}
