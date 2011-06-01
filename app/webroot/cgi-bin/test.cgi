#!/usr/bin/perl
print "Content-type: text/plain\n\n";
print "testing...\n";
use CGI;
use CGI::Carp 'fatalsToBrowser';

#print qq`\$] (Perl version): $]\n`;
#print qq`\$CGI::VERSION: $CGI::VERSION\n`;
#print qq`\nEnvironment Variables:\n\n`;

foreach my $var (sort keys %ENV)
{
#	print "$var: $ENV{$var}\n";
}


#print "\nExecuting 'which convert':\n";
#print `which convert` ? `which convert` : "(command produced no output; no 'convert' in PATH)";
#print "\n";


#print "\nExecuting 'find / -name convert':\n";
#print `find / -name convert`;


