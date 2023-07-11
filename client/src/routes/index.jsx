const routeNames = {
  'home': '/',
  'register': '/register', 
  'login': '/login', 
  'dashboard': '/dashboard', 
  'countries.index': '/countries', 
  'countries.create': '/countries/create', 
  'countries.show': '/countries/:id', 
  'countries.edit': '/countries/:id/edit', 
  'currencies.index': '/currencies', 
  'currencies.create': '/currencies/create', 
  'currencies.show': '/currencies/:id', 
  'currencies.edit': '/currencies/:id/edit', 
  'events.index': '/events', 
  'events.create': '/events/create', 
  'events.show': '/events/:id', 
  'events.edit': '/events/:id/edit', 
  'event-halls.index': '/event-halls', 
  'event-halls.create': '/event-halls/create', 
  'event-halls.show': '/event-halls/:id', 
  'event-halls.edit': '/event-halls/:id/edit', 
  'feedbacks.index': '/feedbacks', 
  'feedbacks.create': '/feedbacks/create', 
  'feedbacks.show': '/feedbacks/:id', 
  'feedbacks.edit': '/feedbacks/:id/edit', 
  'hosts.index': '/hosts', 
  'hosts.create': '/hosts/create', 
  'hosts.show': '/hosts/:id', 
  'hosts.edit': '/hosts/:id/edit', 
  'newsletters.index': '/newsletters', 
  'newsletters.create': '/newsletters/create', 
  'newsletters.show': '/newsletters/:id', 
  'newsletters.edit': '/newsletters/:id/edit', 
  'tickets.index': '/tickets', 
  'tickets.create': '/tickets/create', 
  'tickets.show': '/tickets/:id', 
  'tickets.edit': '/tickets/:id/edit', 
  'ticket-types.index': '/ticket-types', 
  'ticket-types.create': '/ticket-types/create', 
  'ticket-types.show': '/ticket-types/:id', 
  'ticket-types.edit': '/ticket-types/:id/edit', 
  'ticket-verifications.index': '/ticket-verifications', 
  'ticket-verifications.create': '/ticket-verifications/create', 
  'ticket-verifications.show': '/ticket-verifications/:id', 
  'ticket-verifications.edit': '/ticket-verifications/:id/edit', 
  'users.index': '/users', 
  'users.create': '/users/create', 
  'users.show': '/users/:id', 
  'users.edit': '/users/:id/edit', 
}

function route(name, params = {}) {
    let url = routeNames[name]
    
    for (let prop in params) {
        if (Object.prototype.hasOwnProperty.call(params, prop)) {
            url = url.replace(`:${prop}`, params[prop])
        }
    }
    
    return url
}
 
export { route }