#!/usr/bin/env perl

print "Content-Type: text/plain\n\n";

# Use the CGI module
use CGI;

# Create a new CGI object
my $q = CGI->new;

# Access the firstname GET parameter
$first_name = $q->param('firstname');

# Access the lastname GET parameter
$last_name = $q->param('lastname');

# Access the food GET parameter
$food = $q->param('food');

printMessage();

sub printMessage {
    my $msg = "Hello $first_name $last_name!  Did you have $food for lunch?";
    print $msg;
}
