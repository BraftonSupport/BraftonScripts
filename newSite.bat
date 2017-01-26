set site=mynewsiteagain.dev
set apachepath=c:\xampp-5
set folder=c:\jointhtdocs
mkdir %folder%\%site%
echo 127.0.0.1 %site% >> c:\Windows/System32/drivers/etc/hosts

echo ^<VirtualHost *:80^> > %apachepath%\apache\conf\extra\hosts\%site%.conf
echo ServerAdmin webmaster@dummy-host2.example.com >> %apachepath%\apache\conf\extra\hosts\%site%.conf
echo DocumentRoot "%folder%/%site%/" >> %apachepath%\apache\conf\extra\hosts\%site%.conf
echo ServerName %site% >> %apachepath%\apache\conf\extra\hosts\%site%.conf
echo ErrorLog "logs/dummy-host2.example.com-error.log" >> %apachepath%\apache\conf\extra\hosts\%site%.conf
echo CustomLog "logs/dummy-host2.example.com-access.log" common >> %apachepath%\apache\conf\extra\hosts\%site%.conf
echo ^</VirtualHost^> >> %apachepath%\apache\conf\extra\hosts\%site%.conf
