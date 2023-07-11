import axios from 'axios';
import './App.css'
import { Routes, Route } from 'react-router-dom';
import { useAuth } from '@/hooks/useAuth';
import { route } from '@/routes';
import Layout from '@/components/Layout';
import NotFound from '@/views/NotFound';
import Unauthorized from '@/views/Unauthorized';
import Register from '@/views/auth/Register';
import Login from '@/views/auth/Login';
import Home from '@/views/Home';
import Dashboard from '@/views/Dashboard';
import PasswordReset from '@/views/auth/PasswordReset';
import CountriesList from '@/views/countries/CountriesList';
import CreateCountry from '@/views/countries/CreateCountry';
import EditCountry from '@/views/countries/EditCountry';
import Country from '@/views/countries/Country';
import CurrenciesList from '@/views/currencies/CurrenciesList';
import CreateCurrency from '@/views/currencies/CreateCurrency';
import EditCurrency from '@/views/currencies/EditCurrency';
import Currency from '@/views/currencies/Currency';
import EventHallsList from '@/views/event-halls/EventHallsList';
import CreateEventHall from '@/views/event-halls/CreateEventHall';
import EditEventHall from '@/views/event-halls/EditEventHall';
import EventHall from '@/views/event-halls/EventHall';
import EventsList from '@/views/events/EventsList';
import CreateEvent from '@/views/events/CreateEvent';
import EditEvent from '@/views/events/EditEvent';
import Event from '@/views/events/Event';
import FeedbacksList from '@/views/feedbacks/FeedbacksList';
import CreateFeedback from '@/views/feedbacks/CreateFeedback';
import EditFeedback from '@/views/feedbacks/EditFeedback';
import Feedback from '@/views/feedbacks/Feedback';
import HostsList from '@/views/hosts/HostsList';
import CreateHost from '@/views/hosts/CreateHost';
import EditHost from '@/views/hosts/EditHost';
import Host from '@/views/hosts/Host';
// import NewslettersList from '@/views/newsletters/NewslettersList';
// import CreateNewsletter from '@/views/newsletters/CreateNewsletter';
// import EditNewsletter from '@/views/newsletters/EditNewsletter';
// import Newsletter from '@/views/newsletters/Newsletter';
import TicketTypesList from '@/views/ticket-types/TicketTypesList';
import CreateTicketType from '@/views/ticket-types/CreateTicketType';
import EditTicketType from '@/views/ticket-types/EditTicketType';
import TicketType from '@/views/ticket-types/TicketType';
import TicketVerificationsList from '@/views/ticket-verifications/TicketVerificationsList';
import CreateTicketVerification from '@/views/ticket-verifications/CreateTicketVerification';
import EditTicketVerification from '@/views/ticket-verifications/EditTicketVerification';
import TicketVerification from '@/views/ticket-verifications/TicketVerification';
import TicketsList from '@/views/tickets/TicketsList';
import CreateTicket from '@/views/tickets/CreateTicket';
import EditTicket from '@/views/tickets/EditTicket';
import Ticket from '@/views/tickets/Ticket';
import UsersList from '@/views/users/UsersList';
import CreateUser from '@/views/users/CreateUser';
import EditUser from '@/views/users/EditUser';
import User from '@/views/users/User';

window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.axios.defaults.withCredentials = true;
window.axios.defaults.baseURL = "http://127.0.0.1:8001/api/v1";

function App() {
  const { isAuthenticated, isSuperAdmin, isAdmin, isGenericUser, logout } = useAuth()

  return (
    <Routes>
      <Route path='/' element={<Layout />}>

        {/* public routes */}
        <Route path={ route('home') } element={<Home />} />
        <Route path={ route('register') } element={<Register />} />
        <Route path={ route('login') } element={<Login />} />
        {/* end public routes */}
        
        {/* protected routes */}
        {
          isAuthenticated && isSuperAdmin ?
            <>
              <Route path={ route('dashboard') } element={<Dashboard />} />
              <Route path={ route('countries.index') } element={<CountriesList />} />
              <Route path={ route('countries.create') } element={<CreateCountry />} />
              <Route path={ route('countries.edit') } element={<EditCountry />} />
              <Route path={ route('countries.show') } element={<Country />} />
              <Route path={ route('currencies.index') } element={<CurrenciesList />} />
              <Route path={ route('currencies.create') } element={<CreateCurrency />} />
              <Route path={ route('currencies.edit') } element={<EditCurrency />} />
              <Route path={ route('currencies.show') } element={<Currency />} />
              <Route path={ route('event-halls.index') } element={<EventHallsList />} />
              <Route path={ route('event-halls.create') } element={<CreateEventHall />} />
              <Route path={ route('event-halls.edit') } element={<EditEventHall />} />
              <Route path={ route('event-halls.show') } element={<EventHall />} />
              <Route path={ route('events.index') } element={<EventsList />} />
              <Route path={ route('events.create') } element={<CreateEvent />} />
              <Route path={ route('events.edit') } element={<EditEvent />} />
              <Route path={ route('events.show') } element={<Event />} />
              <Route path={ route('feedbacks.index') } element={<FeedbacksList />} />
              <Route path={ route('feedbacks.create') } element={<CreateFeedback />} />
              <Route path={ route('feedbacks.edit') } element={<EditFeedback />} />
              <Route path={ route('feedbacks.show') } element={<Feedback />} />
              <Route path={ route('hosts.index') } element={<HostsList />} />
              <Route path={ route('hosts.create') } element={<CreateHost />} />
              <Route path={ route('hosts.edit') } element={<EditHost />} />
              <Route path={ route('hosts.show') } element={<Host />} />
              {/* <Route path={ route('newsletters.index') } element={<NewslettersList />} />
              <Route path={ route('newsletters.create') } element={<CreateNewsletter />} />
              <Route path={ route('newsletters.edit') } element={<EditNewsletter />} />
              <Route path={ route('newsletters.show') } element={<Newsletter />} /> */}
              <Route path={ route('ticket-types.index') } element={<TicketTypesList />} />
              <Route path={ route('ticket-types.create') } element={<CreateTicketType />} />
              <Route path={ route('ticket-types.edit') } element={<EditTicketType />} />
              <Route path={ route('ticket-types.show') } element={<TicketType />} />
              <Route path={ route('ticket-verifications.index') } element={<TicketVerificationsList />} />
              <Route path={ route('ticket-verifications.create') } element={<CreateTicketVerification />} />
              <Route path={ route('ticket-verifications.edit') } element={<EditTicketVerification />} />
              <Route path={ route('ticket-verifications.show') } element={<TicketVerification />} />
              <Route path={ route('ticket.index') } element={<TicketsList />} />
              <Route path={ route('ticket.create') } element={<CreateTicket />} />
              <Route path={ route('ticket.edit') } element={<EditTicket />} />
              <Route path={ route('ticket.show') } element={<Ticket />} />
              <Route path={ route('user.index') } element={<UsersList />} />
              <Route path={ route('user.create') } element={<CreateUser />} />
              <Route path={ route('user.edit') } element={<EditUser />} />
              <Route path={ route('user.show') } element={<User />} />
            </>
          : isAuthenticated && isAdmin ? 
            <>
              <Route path={ route('dashboard') } element={<Dashboard />} />
              <Route path={ route('password-reset') } element={<PasswordReset />} />
              <Route path="unauthorized" element={<Unauthorized />} />
            </>
          : 
            <>
              <Route path={ route('dashboard') } element={<Dashboard />} />
            </>
        }
        {/* end protected routes */}

        {/* 404 */}
        <Route path="*" element={<NotFound />} />
      </Route>
    </Routes>
  )
}

export default App